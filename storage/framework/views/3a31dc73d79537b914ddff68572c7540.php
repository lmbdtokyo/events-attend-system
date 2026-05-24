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

        .scan-result-overlay {
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(0, 0, 0, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            box-sizing: border-box;
        }

        .scan-result-overlay.is-open {
            display: flex;
        }

        .scan-result-dialog {
            background: #fff;
            border-radius: 12px;
            max-width: 420px;
            width: 100%;
            max-height: min(85vh, 100dvh - 32px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.25);
            font-size: 15px;
            line-height: 1.45;
        }

        .scan-result-body {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding: 18px 16px 8px;
            -webkit-overflow-scrolling: touch;
        }

        .scan-result-footer {
            flex-shrink: 0;
            padding: 12px 16px 14px;
            border-top: 1px solid #eee;
            background: #fff;
        }

        .scan-result-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .scan-result-badge.is-success {
            background: #d4edda;
            color: #155724;
        }

        .scan-result-badge.is-error {
            background: #f8d7da;
            color: #721c24;
        }

        .scan-result-message {
            margin: 0 0 10px;
            font-weight: 600;
            word-break: break-word;
        }

        .scan-result-subheading {
            margin: 0 0 8px;
            font-size: 14px;
            color: #333;
        }

        .scan-result-dl {
            margin: 0;
            padding: 0;
        }

        .scan-result-dl dt {
            margin: 10px 0 2px;
            font-size: 12px;
            color: #666;
            font-weight: 600;
        }

        .scan-result-dl dd {
            margin: 0;
            padding: 0;
            word-break: break-word;
        }

        .scan-result-url {
            margin: 10px 0 0;
            font-size: 11px;
            color: #555;
            word-break: break-all;
        }

        .scan-result-close {
            display: block;
            width: 100%;
            margin: 0;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            background: #007bff;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
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

        <div id="scan-result-overlay" class="scan-result-overlay" aria-hidden="true">
            <div class="scan-result-dialog" role="dialog" aria-modal="true">
                <div class="scan-result-body">
                    <div id="scan-result-badge" class="scan-result-badge"></div>
                    <p id="scan-result-message" class="scan-result-message"></p>
                    <div id="scan-result-user-wrap" class="scan-result-user-wrap" style="display: none;">
                        <h3 id="scan-result-user-heading" class="scan-result-subheading">読み取り情報</h3>
                        <dl id="scan-result-user-dl" class="scan-result-dl"></dl>
                    </div>
                    <p id="scan-result-url" class="scan-result-url"></p>
                </div>
                <div class="scan-result-footer">
                    <button type="button" id="scan-result-close" class="scan-result-close">閉じる</button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
        <script>
                
                const video = document.getElementById('video');
                document.body.append(video);
                const canvasElement = document.getElementById('canvas');
                const canvas = canvasElement.getContext('2d');
    
                let lastCodeData = '';

                const scanOverlay = document.getElementById('scan-result-overlay');
                const scanBadge = document.getElementById('scan-result-badge');
                const scanMessage = document.getElementById('scan-result-message');
                const scanUserWrap = document.getElementById('scan-result-user-wrap');
                const scanUserHeading = document.getElementById('scan-result-user-heading');
                const scanUserDl = document.getElementById('scan-result-user-dl');
                const scanUrlEl = document.getElementById('scan-result-url');
                const scanCloseBtn = document.getElementById('scan-result-close');

                function entryFlgLabel(v) {
                    if (v === 1 || v === '1') return '入場中';
                    if (v === 0 || v === '0') return '退場済み';
                    return '—';
                }

                function participantRows(p) {
                    if (!p || typeof p !== 'object') return [];
                    const rows = [];
                    const isGuestQr = Object.prototype.hasOwnProperty.call(p, 'qr_id');

                    if (!isGuestQr) {
                        if (p.id != null) rows.push(['ID', p.id]);
                        if (p.name != null && p.name !== '') rows.push(['名前', p.name]);
                        if (p.furigana != null && p.furigana !== '') rows.push(['フリガナ', p.furigana]);
                        if (p.company != null && p.company !== '') rows.push(['会社名', p.company]);
                        if (p.mail != null && p.mail !== '') rows.push(['メール', p.mail]);
                        if (p.tel != null && p.tel !== '') rows.push(['電話番号', p.tel]);
                        if (p.section != null && p.section !== '') rows.push(['受付区分', p.section]);
                        if (p.qr != null && p.qr !== '') rows.push(['QRコード', p.qr]);
                    } else {
                        if (p.qr_id != null && p.qr_id !== '') rows.push(['QRコードID', p.qr_id]);
                        if (p.event_id != null) rows.push(['イベントID', p.event_id]);
                    }

                    if (p.entry_flg !== undefined && p.entry_flg !== null) {
                        rows.push(['入場状態', entryFlgLabel(p.entry_flg)]);
                    }

                    return rows;
                }

                function renderParticipantDl(dlEl, rows) {
                    dlEl.innerHTML = '';
                    rows.forEach(([label, value]) => {
                        const dt = document.createElement('dt');
                        dt.textContent = label;
                        const dd = document.createElement('dd');
                        dd.textContent = value === null || value === undefined ? '—' : String(value);
                        dlEl.appendChild(dt);
                        dlEl.appendChild(dd);
                    });
                }

                function openScanResult(isSuccess, messageText, participant, scannedUrl) {
                    scanBadge.textContent = isSuccess ? '成功' : 'エラー';
                    scanBadge.classList.toggle('is-success', isSuccess);
                    scanBadge.classList.toggle('is-error', !isSuccess);
                    scanMessage.textContent = messageText || (isSuccess ? '完了しました。' : 'エラーです。');

                    scanUserHeading.textContent = isSuccess ? '読み取り情報' : '対象者情報';
                    const rows = participantRows(participant);
                    if (rows.length) {
                        renderParticipantDl(scanUserDl, rows);
                        scanUserWrap.style.display = 'block';
                    } else {
                        scanUserWrap.style.display = 'none';
                    }

                    if (scannedUrl) {
                        const max = 52;
                        const short = scannedUrl.length > max ? scannedUrl.slice(0, max) + '…' : scannedUrl;
                        scanUrlEl.textContent = 'URL ' + short;
                        scanUrlEl.setAttribute('title', scannedUrl);
                    } else {
                        scanUrlEl.textContent = '';
                        scanUrlEl.removeAttribute('title');
                    }
                    scanOverlay.classList.add('is-open');
                    scanOverlay.setAttribute('aria-hidden', 'false');
                }

                function closeScanResult() {
                    scanOverlay.classList.remove('is-open');
                    scanOverlay.setAttribute('aria-hidden', 'true');
                    lastCodeData = '';
                }

                scanCloseBtn.addEventListener('click', closeScanResult);

                function normalizeScanPayload(data) {
                    if (!data || typeof data !== 'object') {
                        return { ok: false, message: '応答エラー', user: null };
                    }
                    if (typeof data.message === 'string') {
                        return { ok: !!data.ok, message: data.message, user: data.user ?? null };
                    }
                    if (typeof data.error === 'string') {
                        return { ok: false, message: data.error, user: data.user ?? null };
                    }
                    return { ok: false, message: 'エラーです。', user: null };
                }
    
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
                                    'X-User-ID': <?php echo e(Auth::user()->id); ?>

                                }
                            })
                                .then(function (response) {
                                    const payload = normalizeScanPayload(response.data);
                                    openScanResult(
                                        !!payload.ok,
                                        payload.message,
                                        payload.user,
                                        modifiedUrl
                                    );
                                })
                                .catch(function (error) {
                                    const data = error.response && error.response.data ? error.response.data : null;
                                    const payload = normalizeScanPayload(data);
                                    let msg = payload.message;
                                    if (!error.response) {
                                        msg = '通信エラー';
                                    }
                                    openScanResult(false, msg, payload.user, modifiedUrl);
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