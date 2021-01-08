# yii2-saldo-notifier

1. Rename file "data/balance.php.example" menjadi "data/balance.php" dan sesuaikan dengan akun anda.
2. Buka file "config/notification.php", sesuaikan type notifikasi
2. Seting SMTP server "confg/console.php" (apabila menggunakan notifikasi by email)
3. Tambahkan cron job di server anda  "* *     * * *   root    php /your/yii2-notifikasi-saldo-path/yii bca/check user".

**update 08/01/2021**
1. Remove unused Email Notification
2. Send notification only when change > 10.000
3. Tidy up some codes

**update 03/01/2020**
1. Fix "decrease" balance

**update 02/01/2020**
1. Update versi Yii2
2. Telegram Notification (Bot)
3. Email Notification (On Progress)
4. Fix zero result
5. Added limit balance notification

**NOTE:**
- Notifikasi akan dikirim apabila ada perubahan melebihi 10.000
- Terkadang Server BCA merespon saldo dengan hasil 0 - rate limit
- Hanya mendukung Bank BCA.
- Hati-hati jika mengupload applikasi ini, minimal hanya anda yang memiliki akses ke server anda.






