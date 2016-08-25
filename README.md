# yii2-saldo-notifier

1. Buka file "data/balance.php" dan sesuaikan dengan akun anda.
2. Seting SMTP server confg/web.php 
3. Tambahkan cron job di server anda  "* *     * * *   root    php /your/yii2-notifikasi-saldo-path/yii bca/check user".

**NOTE:**
- Terkadang Server BCA merespon saldo dengan hasil 0 - rate limit
- Hanya mendukung Bank BCA.
- Hati-hati jika mengupload applikasi ini, pastikan server anda aman !!!






