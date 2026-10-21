/* ==========================================================================
   SaldoKita — App & Interaction Logic
   - Live FX Simulation via /api/simulate
   - Real-time Debounced Calculations & Preset Chips
   - Copy-to-Clipboard with Feedback
   - Dashboard Live Estimates
   ========================================================================== */
(function ($) {
    'use strict';

    const fmt = (n) =>
        'Rp ' + Math.round(n).toLocaleString('id-ID', { maximumFractionDigits: 0 });

    const fmtUsd = (n) => 'US$ ' + Number(n).toLocaleString('en-US', { minimumFractionDigits: 0 });

    // ---------- Currency Calculator (sim-card) ----------
    const $simCards = $('.sim-card[data-type]');

    function calculateSim($card) {
        const type = $card.data('type') || 'topup';
        const $amountInput = $card.find('.sim-amount');
        const amount = parseFloat($amountInput.val());
        const minVal = parseFloat($amountInput.attr('min')) || 1;

        if (!amount || amount < minVal) {
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

        $.get(SIM_API, { type: type, amount: amount })
            .done((r) => {
                $card.find('.sim-fee').text(fmt(r.fee || 0));
                $card.find('.sim-rate').text(fmt(r.rate));
                if ($card.find('.sim-usd').length) {
                    $card.find('.sim-usd').text(fmtUsd(r.usd));
                }
                $card.find('.sim-total').text(fmt(r.rupiah));

                // Update WhatsApp direct link with structured pre-filled order text
                const serviceName = type === 'pay' ? 'Jasa Pembayaran Online PayPal' : 'Top Up Saldo PayPal';
                const waText = 'Halo SaldoKita, saya ingin melakukan transaksi ' + serviceName + ':\n' +
                    '• Nominal: $' + r.usd + ' USD\n' +
                    '• Estimasi Total: ' + fmt(r.rupiah) + '\n' +
                    'Mohon arahan rekening pembayaran. Terima kasih.';

                const currentHref = $card.find('.sim-order').attr('href') || '';
                const baseWa = currentHref.split('?')[0] || 'https://wa.me/6281234567890';
                $card.find('.sim-order').attr(
                    'href',
                    baseWa + '?' + $.param({ text: waText })
                );
            })
            .fail((xhr) => {
                const msg = (xhr.responseJSON && xhr.responseJSON.error) || 'Gagal menghitung, coba lagi.';
                $card.find('.sim-total').text(msg);
            })
            .always(() => {
                if ($spinner.length) {
                    $spinner.addClass('d-none');
                    if ($btnText.length) { $btnText.text('Hitung Estimasi'); }
                }
            });
    }

    // Trigger on button click
    $simCards.on('click', '.sim-btn', function (e) {
        e.preventDefault();
        const $card = $(this).closest('[data-type]');
        calculateSim($card);
    });

    // Preset chips click ($50, $100, $200, etc.)
    $(document).on('click', '.chip-btn', function (e) {
        e.preventDefault();
        const val = $(this).data('val');
        const $card = $(this).closest('.sim-card');
        $card.find('.sim-amount').val(val).trigger('input');
    });

    // Debounced live calculation on typing
    let typingTimer;
    $simCards.on('input', '.sim-amount', function () {
        const $card = $(this).closest('[data-type]');
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            calculateSim($card);
        }, 350);
    });

    // Enter key triggers immediately
    $simCards.on('keyup', '.sim-amount', function (e) {
        if (e.key === 'Enter') {
            clearTimeout(typingTimer);
            calculateSim($(this).closest('[data-type]'));
        }
    });

    // Run initial calculation on page load for all visible sim cards
    $(document).ready(function () {
        $simCards.each(function () {
            calculateSim($(this));
        });
    });

    // Recalculate when Bootstrap tab is shown
    $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
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

        $amount.on('input change blur', function () {
            const amount = parseFloat($(this).val());
            const type = $orderForm.attr('action').includes('jasa-bayar') ? 'pay' : 'topup';

            if (!amount || amount <= 0) { return; }

            $.get(SIM_API, { type: type, amount: amount })
                .done((r) => {
                    $('#simBox .sim-fee').text(fmt(r.fee || 0));
                    $('#simBox .sim-rate').text(fmt(r.rate));
                    $('#simBox .sim-total').text(fmt(r.rupiah));
                    $box.removeClass('d-none');
                    if ($hint.length) {
                        $hint.text('Total di atas adalah nominal transfer final saat order dibuat.');
                    }
                });
        }).trigger('change');
    }

    // ---------- One-Click Copy to Clipboard ----------
    $(document).on('click', '.btn-copy', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const textToCopy = $btn.data('copy') || $btn.text().trim();

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showCopyFeedback($btn);
            });
        } else {
            // Fallback for older browsers
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
