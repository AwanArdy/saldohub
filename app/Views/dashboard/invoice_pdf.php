<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: "Helvetica", "DejaVu Sans", sans-serif; color: #1c2333; font-size: 12px; }
    .head { display: table; width: 100%; margin-bottom: 26px; }
    .brand { display: table-cell; vertical-align: top; }
    .brand h1 { font-size: 20px; color: #155ee2; }
    .brand h1 span { color: #1c2333; }
    .brand small { color: #6b7280; }
    .meta { display: table-cell; vertical-align: top; text-align: right; }
    .meta .inv-no { font-size: 16px; font-weight: bold; margin-bottom: 4px; }
    .meta .inv-status { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 10px; font-weight: bold; }
    .boxes { display: table; width: 100%; margin-bottom: 22px; }
    .boxes .col { display: table-cell; width: 50%; vertical-align: top; }
    .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin-bottom: 5px; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 6px; }
    table.items th { background: #f6f8fc; text-align: left; padding: 9px 10px; font-size: 11px; }
    table.items td { padding: 9px 10px; border-bottom: 1px solid #eceff5; }
    .r { text-align: right !important; }
    .totals { width: 260px; margin-top: 14px; margin-left: auto; }
    .totals td { padding: 6px 4px; }
    .totals .grand td { border-top: 2px solid #155ee2; font-weight: bold; font-size: 14px; color: #155ee2; }
    .note { background: #f6f8fc; border: 1px solid #e9edf4; padding: 12px 14px; border-radius: 6px; margin-top: 18px; font-size: 11px; color: #444; }
    .footer { margin-top: 30px; text-align: center; color: #9ca3af; font-size: 10px; border-top: 1px solid #eceff5; padding-top: 10px; }
</style>
</head>
<?php
$invNo  = 'INV-' . str_pad((string) $order['id'], 5, '0', STR_PAD_LEFT);
$statusLabels = [
    'pending'    => ['MENUNGGU PEMBAYARAN', '#fff3cd', '#8a6100'],
    'processing' => ['DIPROSES', '#cff4fc', '#055160'],
    'done'       => ['SELESAI', '#d1e7dd', '#0f5132'],
    'cancelled'  => ['DIBATALKAN', '#f8d7da', '#842029'],
];
[$statusText, $sBg, $sFg] = $statusLabels[$order['status']] ?? [strtoupper($order['status']), '#eee', '#333'];
?>
<body>
    <div class="head">
        <div class="brand">
            <h1>SaldoKita</h1>
            <small>Jasa transaksi PayPal &mdash; saldokita.test</small><br>
            <small>halo@saldokita.test</small>
        </div>
        <div class="meta">
            <div class="inv-no">INVOICE #<?= $invNo ?></div>
            <div>Tanggal: <?= date('d M Y', strtotime($order['created_at'])) ?></div>
            <div class="inv-status" style="background:<?= $sBg ?>; color:<?= $sFg ?>">
                <?= $statusText ?>
            </div>
        </div>
    </div>

    <div class="boxes">
        <div class="col">
            <div class="section-title">Ditujukan kepada</div>
            <strong><?= esc($user['name'] ?? 'Pelanggan') ?></strong><br>
            <?= esc($user['email'] ?? '-') ?><br>
            <?php if (!empty($order['paypal_acc'])) : ?>
                Akun PayPal tujuan: <?= esc($order['paypal_acc']) ?><br>
            <?php endif; ?>
            <?php if (!empty($order['item_url'])) : ?>
                Item: <small><?= esc($order['item_url']) ?></small>
            <?php endif; ?>
        </div>
        <div class="col">
            <div class="section-title">Rekening pembayaran</div>
            <strong><?= esc($settings['bank_name'] ?? 'BCA') ?></strong> &mdash; <?= esc($settings['bank_account'] ?? '-') ?><br>
            a.n. <?= esc($settings['bank_holder'] ?? '-') ?>
        </div>
    </div>

    <div class="section-title">Bentuk layanan</div>
    <table class="items">
        <tr>
            <th>Deskripsi</th>
            <th class="r">Nominal</th>
            <th class="r">Harga</th>
            <th class="r">Jumlah</th>
        </tr>
        <tr>
            <td>
                <?= $order['type'] === 'topup'
                    ? 'Top Up Saldo PayPal ke ' . esc($order['paypal_acc'])
                    : 'Jasa pembayaran item online: ' . esc($order['item_url']) ?>
                <?php if (!empty($order['note'])) : ?><br><small>Catatan: <?= esc($order['note']) ?></small><?php endif; ?>
            </td>
            <td class="r">$<?= number_format((float) $order['amount'], 2) ?></td>
            <td class="r">Rp <?= number_format((float) $order['rate'], 0, ',', '.') ?></td>
            <td class="r">Rp <?= number_format((float) $order['amount'] * $order['rate'], 0, ',', '.') ?></td>
        </tr>
        <?php if ($order['type'] === 'pay') : ?>
        <tr>
            <td>Biaya admin <?= esc($settings['admin_fee_pct'] ?? 4) ?>% (min Rp <?= number_format((float) ($settings['admin_fee_min'] ?? 30000), 0, ',', '.') ?>)</td>
            <td class="r">&mdash;</td>
            <td class="r">&mdash;</td>
            <td class="r">Rp <?= number_format((float) $order['admin_fee'], 0, ',', '.') ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="r">Rp <?= number_format((float) $order['amount'] * $order['rate'], 0, ',', '.') ?></td>
        </tr>
        <?php if ($order['type'] === 'pay') : ?>
        <tr>
            <td>Admin</td>
            <td class="r">Rp <?= number_format((float) $order['admin_fee'], 0, ',', '.') ?></td>
        </tr>
        <?php endif; ?>
        <tr class="grand">
            <td>TOTAL</td>
            <td class="r">Rp <?= number_format((float) $order['total_rupiah'], 0, ',', '.') ?></td>
        </tr>
    </table>

    <div class="note">
        <strong>Cara pembayaran:</strong> transfer tepat sebesar total di atas ke rekening tercantum,
        Tuliskan nomor invoice <strong>#<?= $invNo ?></strong>
        pada berita transfer bila dimungkinkan. Order berstatus <em>menunggu pembayaran</em> akan diproses
        begitu dana diterima dan diverifikasi.
    </div>

    <div class="footer">
        Dokumen ini dibuat otomatis oleh sistem SaldoKita dan sah tanpa tanda tangan basah. &copy; <?= date('Y') ?> SaldoKita.
    </div>
</body>
</html>
