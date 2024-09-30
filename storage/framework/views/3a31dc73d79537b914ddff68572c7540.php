<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRスキャン画面</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">


    <style>
        body{
            font-family: 'Zen Kaku Gothic', sans-serif;
            background-color: rgba(255, 255, 255, 0); /* 背景を透明にする */
        }

        #canvas{
            width: 100%;
            height: 100dvh;
            position: fixed;;
        }

        .titlebox{
        background-color: rgba(255, 255, 255, 0.0); /* 背景を透明にする */
        text-align: center;
        }

        h2{
        position: relative;
        text-align: center;
        color: white;
        background-color: rgba(0, 0, 0, 1);
        padding: 20px;
        font-weight: bold;
        }
    </style>

</head>
<body>

        <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
            <button onclick="location.reload();" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                更新
            </button>
        </div>

        <div class="titlebox">
        <h2><?php echo e($exitentry == 1 ? '入場スキャン画面' : '退場スキャン画面'); ?></h2>
        </div>
        
        <video id="video" style="position:absolute;opacity:0;top:0;left:0;z-index:-1000;" autoplay playsinline muted></video>
        <canvas id="canvas" hidden></canvas>
    
        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
        <script>
                
                const video = document.getElementById('video');
                document.body.append(video);
                const canvasElement = document.getElementById('canvas');
                const canvas = canvasElement.getContext('2d');

                // const userAgent = 'CustomUserAgent/1.0; UserID=' + <?php echo e(Auth::user()->id); ?>;
                // alert(userAgent);
    
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

                            //URLチェックを行う
                            if (!/^https?:\/\/[^\/]+\/events\/[^\/]+\/qr\//.test(code.data)) {
                                console.warn('無効なURLです: ' + code.data);
                                return;
                            }
    
                            axios.get(modifiedUrl, {
                                headers: {
                                    'User-Agent': 'CustomUserAgent/1.0; UserID=' + <?php echo e(Auth::user()->id); ?>

                                }
                            })
                                .then(function (response) {
                                    alert('QRコードのURLにアクセスしました: ' + modifiedUrl + JSON.stringify(response.data));
                                })
                                .catch(function (error) {
                                    alert('QRコードのURLへのアクセスに失敗しました: ' + modifiedUrl + JSON.stringify(error.response.data));
                                });
    
                            //Livewire.emit('handleQrUrl', code.data);
                        }
                    }
                    requestAnimationFrame(tick);
                }
    
                startCamera();
        </script>
</body>
</html><?php /**PATH /data/resources/views/events/scan.blade.php ENDPATH**/ ?>