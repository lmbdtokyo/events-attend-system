<div>
    {{-- <div id="qr-reader" style="width: 100vw; height: 100vh;"></div> --}}
    <video id="video" style="width: 100vw; height: 100vh; border: 1px solid gray;"></video>
    <canvas id="canvas" hidden></canvas>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
            
            const video = document.getElementById('video');
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
                        const modifiedUrl = code.data + '/1';

                        axios.get(modifiedUrl)
                            .then(function (response) {
                                alert('QRコードのURLにアクセスしました: ', response.data);
                            })
                            .catch(function (response) {
                                alert('QRコードのURLへのアクセスに失敗しました: ', response.data);
                            });

                        //Livewire.emit('handleQrUrl', code.data);
                    }
                }
                requestAnimationFrame(tick);
            }

            startCamera();



        // document.addEventListener('livewire:load', function () {
        //     console.log('Livewire is loaded');
            
        //     const video = document.getElementById('video');
        //     const canvasElement = document.getElementById('canvas');
        //     const canvas = canvasElement.getContext('2d');

        //     function startCamera() {
        //         if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        //             navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(function(stream) {
        //                 video.srcObject = stream;
        //                 video.setAttribute('playsinline', true); // iOS対応
        //                 video.play();
        //                 requestAnimationFrame(tick);
        //             }).catch(function(err) {
        //                 console.error('カメラの起動に失敗しました: ', err);
        //                 alert('カメラの起動に失敗しました: ' + err.message);
        //             });
        //         } else {
        //             alert('お使いのブラウザはカメラ機能をサポートしていません。');
        //         }
        //     }

        //     function tick() {
        //         if (video.readyState === video.HAVE_ENOUGH_DATA) {
        //             canvasElement.hidden = false;
        //             canvasElement.height = video.videoHeight;
        //             canvasElement.width = video.videoWidth;
        //             canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
        //             const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
        //             const code = jsQR(imageData.data, imageData.width, imageData.height, {
        //                 inversionAttempts: 'dontInvert',
        //             });
        //             if (code) {
        //                 alert('QRコードが読み取られました: ' + code.data);
        //                 // Livewireのメソッドを呼び出してURLを送信
        //                 Livewire.emit('handleQrUrl', code.data);
        //             }
        //         }
        //         requestAnimationFrame(tick);
        //     }

        //     startCamera();
        // });

        // Livewireのレスポンスを受け取ってアラートを表示
        // Livewire.on('qrUrlProcessed', message => {
        //     alert(message);
        // });
    </script>
</div>