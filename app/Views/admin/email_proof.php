<!DOCTYPE html>
<html lang="id">
<body style="font-family:Helvetica,Arial,sans-serif;color:#1c2333;font-size:14px;line-height:1.6;margin:0;padding:24px;background:#f6f8fc;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;padding:28px;">
                    <tr>
                        <td style="padding-bottom:18px;border-bottom:2px solid #eef1f6;">
                            <h2 style="color:#155ee2;margin:0;font-size:20px;">SaldoKita</h2>
                        </td>
                    </tr>
                    <tr><td style="padding:18px 0 6px;">
                        <h3 style="margin:0 0 8px;">Saldo kamu sudah dikirim &#128640;</h3>
                        <p style="color:#6b7280;margin:0;">
                            Halo <?= esc($user['name']) ?>, order <strong>#<?= $invNo ?></strong> telah kami proses dan selesai.
                            Bukti pengiriman terlampir pada email ini.
                        </p>
                    </td></tr>
                    <tr><td style="padding:10px 0;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f8fc;border-radius:8px;padding:14px;font-size:13px;">
                            <tr>
                                <td style="color:#6b7280;padding:4px 0;">Layanan</td>
                                <td align="right"><?= $order['type'] === 'topup' ? 'Top Up Saldo PayPal' : 'Jasa Pembayaran PayPal' ?></td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;padding:4px 0;">Nominal</td>
                                <td align="right">US$ <?= number_format((float) $order['amount'], 2) ?></td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;padding:4px 0;">Total dibayar</td>
                                <td align="right">Rp <?= number_format((float) $order['total_rupiah'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;padding:4px 0;">Status</td>
                                <td align="right" style="color:#0f5132;font-weight:bold;">SELESAI</td>
                            </tr>
                        </table>
                    </td></tr>
                    <tr><td style="padding:14px 0;" align="center">
                        <a href="<?= esc($proofUrl) ?>" style="display:inline-block;background:#155ee2;color:#fff;text-decoration:none;padding:11px 26px;border-radius:8px;font-weight:bold;">
                            Lihat Bukti Pengiriman
                        </a>
                    </td></tr>
                    <tr><td style="padding:12px 0;border-top:1px solid #eef1f6;">
                        <p style="color:#9ca3af;font-size:12px;margin:0;">
                            Bila ada kendala, reply email ini atau hubungi kami dengan menyebut nomor order <strong>#<?= $invNo ?></strong>.<br>
                            Email otomatis &mdash; SaldoKita. <?= date('Y') ?>
                        </p>
                    </td></tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
