/* ==========================================================================
   SaldoHub — App & Interaction Logic
   - Live FX Simulation via /api/simulate
   - Real-time Debounced Calculations & Preset Chips
   - Robust Number & Currency Formatting (Guaranteed Anti-NaN)
   - Copy-to-Clipboard with Feedback
   - Dashboard Live Estimates
   ========================================================================== */
(function ($) {
    'use strict';

    // Robust currency formatters that NEVER output NaN
    const fmt = (n) => {
        const num = Number(n);
        if (isNaN(num) || n === null || n === undefined) {
            return 'Rp 0';
        }
        return 'Rp ' + Math.round(num).toLocaleString('id-ID', { maximumFractionDigits: 0 });
    };

    const fmtUsd = (n) => {
        const num = Number(n);
        if (isNaN(num) || n === null || n === undefined) {
            return 'US$ 0';
        }
        return 'US$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 0 });
    };

    // Safe API endpoint resolver
    const apiEndpoint = (typeof SIM_API !== 'undefined' && SIM_API) ? SIM_API : '/api/simulate';

    // Helper to extract clean numeric value from input
    function parseCleanAmount($input) {
        const raw = String($input.val() || '').replace(/[^0-9.]/g, '');
        const val = parseFloat(raw);
        return isNaN(val) ? 0 : val;
    }

    // ---------- Currency Calculator (sim-card) ----------
    const $simCards = $('.sim-card[data-type]');

    function calculateSim($card) {
        if (!$card || !$card.length) { return; }

        const type = $card.data('type') || 'topup';
        const $amountInput = $card.find('.sim-amount');
        const amount = parseCleanAmount($amountInput);
        const minVal = parseFloat($amountInput.attr('min')) || 1;

        if (amount < minVal) {
            $card.find('.sim-total').text('Min. US$ ' + minVal);
            return;
        }

        const $btn = $card.find('.sim-btn');
        const $spinner = $btn.find('.spinner-border');
        const $btnText = $btn.find('.btn-text');

        if ($spinner.length) {
            $spinner.removeClass('d-none');
            if ($btnText.length) { $btnText.text('Menghitung...'); }
        }

        $.ajax({
            url: apiEndpoint,
            type: 'GET',
            data: { type: type, amount: amount },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .done((response) => {
            let r = response;
            // Fallback parse if jQuery received string instead of object
            if (typeof r === 'string') {
                try { r = JSON.parse(r); } catch (e) { /* ignore */ }
            }

            if (!r || typeof r !== 'object') {
                $card.find('.sim-total').text('Gagal memproses estimasi');
                return;
            }

            if (r.error) {
                $card.find('.sim-total').text(r.error);
                return;
            }

            const fee = Number(r.fee) || 0;
            const rate = Number(r.rate) || 0;
            const usd = Number(r.usd) || amount;
            const rupiah = Number(r.rupiah) || (usd * rate + fee);

            $card.find('.sim-fee').text(fmt(fee));
            $card.find('.sim-rate').text(fmt(rate));
            if ($card.find('.sim-usd').length) {
                $card.find('.sim-usd').text(fmtUsd(usd));
            }
            $card.find('.sim-total').text(fmt(rupiah));

            // Update WhatsApp direct link with structured pre-filled order text
            const serviceName = type === 'pay' ? 'Jasa Pembayaran Online PayPal' : 'Top Up Saldo PayPal';
            const waText = 'Halo SaldoHub, saya ingin melakukan transaksi ' + serviceName + ':\n' +
                '• Nominal: $' + usd + ' USD\n' +
                '• Estimasi Total: ' + fmt(rupiah) + '\n' +
                'Mohon arahan rekening pembayaran. Terima kasih.';

            const currentHref = $card.find('.sim-order').attr('href') || '';
            const baseWa = currentHref.split('?')[0] || 'https://wa.me/6281234567890';
            $card.find('.sim-order').attr(
                'href',
                baseWa + '?' + $.param({ text: waText })
            );
        })
        .fail((xhr) => {
            let errorMsg = 'Gagal menghitung, coba lagi.';
            try {
                const res = typeof xhr.responseJSON === 'object' ? xhr.responseJSON : JSON.parse(xhr.responseText);
                if (res && res.error) { errorMsg = res.error; }
            } catch (e) { /* ignore */ }
            $card.find('.sim-total').text(errorMsg);
        })
        .always(() => {
            if ($spinner.length) {
                $spinner.addClass('d-none');
                if ($btnText.length) { $btnText.text('Hitung Estimasi'); }
            }
        });
    }

    // Trigger on button click (delegated so dynamically added elements also work)
    $(document).on('click', '.sim-btn', function (e) {
        e.preventDefault();
        const $card = $(this).closest('.sim-card');
        calculateSim($card);
    });

    // Preset chips click ($50, $100, $250, etc.)
    $(document).on('click', '.chip-btn', function (e) {
        e.preventDefault();
        const val = $(this).data('val');
        const $card = $(this).closest('.sim-card');
        $card.find('.sim-amount').val(val).trigger('input');
    });

    // Debounced live calculation on typing
    let typingTimer;
    $(document).on('input', '.sim-card .sim-amount', function () {
        const $card = $(this).closest('.sim-card');
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            calculateSim($card);
        }, 300);
    });

    // Enter key triggers immediately
    $(document).on('keyup', '.sim-card .sim-amount', function (e) {
        if (e.key === 'Enter') {
            clearTimeout(typingTimer);
            calculateSim($(this).closest('.sim-card'));
        }
    });

    // Run initial calculation on page load for all visible sim cards
    $(document).ready(function () {
        $('.sim-card[data-type]').each(function () {
            calculateSim($(this));
        });
    });

    // Recalculate when Bootstrap tab is shown
    $(document).on('shown.bs.tab', 'button[data-bs-toggle="pill"]', function (e) {
        const targetId = $(e.target).data('bs-target');
        const $activeTab = $(targetId);
        $activeTab.find('.sim-card').each(function () {
            calculateSim($(this));
        });
    });

    // ---------- Dashboard Form: Live Estimate ----------
    const $orderForm = $('#orderForm');
    if ($orderForm.length) {
        const $hint = $('#simHint');
        const $box = $('#simBox');
        const $amount = $orderForm.find('.sim-amount');

        function updateDashboardEstimate() {
            const amount = parseCleanAmount($amount);
            const action = String($orderForm.attr('action') || '');
            const type = action.includes('jasa-bayar') ? 'pay' : 'topup';

            if (!amount || amount <= 0) { return; }

            $.ajax({
                url: apiEndpoint,
                type: 'GET',
                data: { type: type, amount: amount },
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .done((response) => {
                let r = response;
                if (typeof r === 'string') {
                    try { r = JSON.parse(r); } catch (e) { /* ignore */ }
                }

                if (!r || typeof r !== 'object') { return; }

                const fee = Number(r.fee) || 0;
                const rate = Number(r.rate) || 0;
                const rupiah = Number(r.rupiah) || (amount * rate + fee);

                $('#simBox .sim-fee').text(fmt(fee));
                $('#simBox .sim-rate').text(fmt(rate));
                $('#simBox .sim-total').text(fmt(rupiah));
                $box.removeClass('d-none');
                if ($hint.length) {
                    $hint.text('Total di atas adalah nominal transfer final saat order dibuat.');
                }
            });
        }

        $amount.on('input change blur', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(updateDashboardEstimate, 250);
        });

        // Initial estimate on dashboard form load
        updateDashboardEstimate();
    }

    // ---------- One-Click Copy to Clipboard ----------
    $(document).on('click', '.btn-copy', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const textToCopy = String($btn.data('copy') || $btn.text()).trim();

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showCopyFeedback($btn);
            });
        } else {
            const $temp = $('<textarea>');
            $('body').append($temp);
            $temp.val(textToCopy).select();
            document.execCommand('copy');
            $temp.remove();
            showCopyFeedback($btn);
        }
    });

    function showCopyFeedback($btn) {
        const origHtml = $btn.html();
        $btn.html('<i class="bi bi-check2 text-success me-1"></i>Tersalin!');
        $btn.addClass('btn-copy-success');
        setTimeout(() => {
            $btn.html(origHtml);
            $btn.removeClass('btn-copy-success');
        }, 1800);
    }

})(jQuery);
