# yii2-saldo-notifier

1. Buka file "data/balance.php" dan sesuaikan dengan akun anda.
2. Buka file "config/notification.php", sesuaikan limit dan type notifikasi
2. Seting SMTP server "confg/console.php" (apabila menggunakan notifikasi by email)
3. Tambahkan cron job di server anda  "* *     * * *   root    php /your/yii2-notifikasi-saldo-path/yii bca/check user".

**update 03/01/2020**
1. Fix "decrease" balance

**update 02/01/2020**
1. Update versi Yii2
2. Telegram Notification (Bot)
3. Email Notification (On Progress)
4. Fix zero result
5. Added limit balance notification

**NOTE:**
- Notifikasi akan dikirim apabila ada perubahan melebihi seting limit di file "config/notification.php"
- Terkadang Server BCA merespon saldo dengan hasil 0 - rate limit
- Hanya mendukung Bank BCA.
- Hati-hati jika mengupload applikasi ini, pastikan server anda aman !!!






