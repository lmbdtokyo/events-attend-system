<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRスキャン画面</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

</head>
<body>
    <div>

        <div>
            <?php if(Auth::check()): ?>
                <p>ログインしています: <?php echo e(Auth::user()->name); ?></p>
            <?php else: ?>
                <p>ログインしていません。</p>
            <?php endif; ?>
        </div>
        
        <video id="video" style="position:absolute;opacity:0;top:0;left:0;z-index:-1000;" autoplay playsinline muted></video>
        <canvas id="canvas" hidden></canvas>
    
        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
        <script>
                
                const video = document.getElementById('video');
                document.body.append(video);
                const canvasElement = document.getElementById('canvas');
                const canvas = canvasElement.getContext('2d');
    
                let lastCodeData = '';
    
                function startCamera() {
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(function(stream) {
                            video.srcObject = stream;
                            video.setAttribute('playsinline', true); // iOS対応
                            video.play();
                            requestAnimationFrame(tick);
                        }).catch(function(err) {
                            console.error('カメラの起動に失敗しました: ', err);
                            alert('カメラの起動に失敗しました: ' + err.message);
                        });
                    } else {
                        alert('お使いのブラウザはカメラ機能をサポートしていません。');
                    }
                }
    
                function tick() {
                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        canvasElement.hidden = false;
                        canvasElement.height = video.videoHeight;
                        canvasElement.width = video.videoWidth;
                        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                        const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: 'dontInvert',
                        });
                        
    
                        if (code && code.data !== lastCodeData) {
                            lastCodeData = code.data;
                            const modifiedUrl = code.data + '/<?php echo e($exitentry); ?>';
    
                            axios.get(modifiedUrl, {
                                headers: {
                                    'User-Agent': 'CustomUserAgent/1.0; UserID=' + <?php echo e(Auth::user()->id); ?>

                                }
                            })
                                .then(function (response) {
                                    alert('QRコードのURLにアクセスしました: ' + JSON.stringify(response.data));
                                })
                                .catch(function (error) {
                                    alert('QRコードのURLへのアクセスに失敗しました: ' + JSON.stringify(error.response.data));
                                });
    
                            //Livewire.emit('handleQrUrl', code.data);
                        }
                    }
                    requestAnimationFrame(tick);
                }
    
                startCamera();
        </script>
    </div>
</body>
</html><?php /**PATH /data/resources/views/events/scan.blade.php ENDPATH**/ ?>