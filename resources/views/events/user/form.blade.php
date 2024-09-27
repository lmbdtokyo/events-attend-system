<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/style.css')
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <title>{{ $eventbasic->title }}</title>
    <style>
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 50px 100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;

        }
        h1 {
            text-align: center;
            color: #333;
        }

        h2{
            padding: 0.5em;/*文字周りの余白*/
            color: #010101;/*文字色*/
            background: #eaf3ff;/*背景色*/
            border-bottom: solid 3px #516ab6;/*下線*/
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }

        ul{
            list-style: none;
            padding: 0px;            
        }
    </style>
</head>
<body>

    <div class="container">

        @if ($eventbasic->image)
                <img src="{{ Storage::url($eventbasic->image) }}" alt="イベント画像" style="max-width: 100%; height: auto;">
        @endif

        <h1>{{ $eventbasic->title }}</h1>

        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif


        <h2>{{ $eventbasic->overview_title }}</h2>

        <p>
            {!! $eventbasic->overview_text !!} 
        </p>

        <h2>開催情報</h2>

        <p>場所: {{ $event->place }}</p>
        <p>開催日</p>
        <ul>
            @php
                $eventDates = json_decode($event->event_date);
            @endphp

            @foreach ($eventDates as $eventDate)
                <li>
                    {{ $eventDate->date }}: {{ \Carbon\Carbon::parse($eventDate->starttime)->format('H:i') }} - {{ \Carbon\Carbon::parse($eventDate->endtime)->format('H:i') }}
                </li>
            @endforeach
        </ul>

        @php
            $currentDate = \Carbon\Carbon::now();
        @endphp

        @if ($currentDate->between($eventbasic->start, $eventbasic->end))
            <h2>お申込みフォーム</h2>


                
            <form action="{{ route('eventform.store', $event->id) }}" method="POST">
                @csrf
                @method('PATCH')

                @if ($eventsetting->name_flg)
                    <div class="form-group">
                        <label for="name">{{ $eventsetting->name_display_name }} @if($eventsetting->name_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="{{ $eventsetting->name_placeholder }}" value="{{ old('name') }}" @if($eventsetting->name_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->furigana_flg)
                    <div class="form-group">
                        <label for="furigana">{{ $eventsetting->furigana_display_name }} @if($eventsetting->furigana_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="furigana" name="furigana" class="form-control" placeholder="{{ $eventsetting->furigana_placeholder }}" value="{{ old('furigana') }}" @if($eventsetting->furigana_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->company_flg)
                    <div class="form-group">
                        <label for="company">{{ $eventsetting->company_display_name }} @if($eventsetting->company_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="company" name="company" class="form-control" placeholder="{{ $eventsetting->company_placeholder }}" value="{{ old('company') }}" @if($eventsetting->company_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->division_flg)
                    <div class="form-group">
                        <label for="division">{{ $eventsetting->division_display_name }} @if($eventsetting->division_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="division" name="division" class="form-control" placeholder="{{ $eventsetting->division_placeholder }}" value="{{ old('division') }}" @if($eventsetting->division_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->post_flg)
                    <div class="form-group">
                        <label for="post">{{ $eventsetting->post_display_name }} @if($eventsetting->post_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="post" name="post" class="form-control" placeholder="{{ $eventsetting->post_placeholder }}" value="{{ old('post') }}" @if($eventsetting->post_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->postal_code_flg)
                    <div class="form-group">
                        <label for="postal_code">{{ $eventsetting->postal_code_display_name }} @if($eventsetting->postal_code_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="{{ $eventsetting->postal_code_placeholder }}" value="{{ old('postal_code') }}" @if($eventsetting->postal_code_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->address1_flg)
                    <div class="form-group">
                        <label for="address1">{{ $eventsetting->address1_display_name }} @if($eventsetting->address1_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="address1" name="address1" class="form-control" placeholder="{{ $eventsetting->address1_placeholder }}" value="{{ old('address1') }}" @if($eventsetting->address1_required_flg) required @endif>
                    </div>
                @endif

                @if ($eventsetting->address2_flg)
                    <div class="form-group">
                        <label for="address2">{{ $eventsetting->address2_display_name }} @if($eventsetting->address2_required_flg) <span style="color: red;">*</span> @endif</label>
                        <input type="text" id="address2" name="address2" class="form-control" placeholder="{{ $eventsetting->address2_placeholder }}" value="{{ old('address2') }}" @if($eventsetting->address2_required_flg) required @endif>
                    </div>
                @endif


            @if ($eventsetting->address3_flg)
                <div class="form-group">
                    <label for="address3">{{ $eventsetting->address3_display_name }} @if($eventsetting->address3_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="address3" name="address3" class="form-control" placeholder="{{ $eventsetting->address3_placeholder }}" value="{{ old('address3') }}" @if($eventsetting->address3_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->tel_flg)
                <div class="form-group">
                    <label for="tel">{{ $eventsetting->tel_display_name }} @if($eventsetting->tel_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="tel" name="tel" class="form-control" placeholder="{{ $eventsetting->tel_placeholder }}" value="{{ old('tel') }}" @if($eventsetting->tel_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->birth_flg)
                <div class="form-group">
                    <label for="birth">{{ $eventsetting->birth_display_name }} @if($eventsetting->birth_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="date" id="birth" name="birth" class="form-control" placeholder="{{ $eventsetting->birth_placeholder }}" value="{{ old('birth') }}" @if($eventsetting->birth_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->section_flg)
                <div class="form-group">
                    <label for="section">{{ $eventsetting->section_display_name }} @if($eventsetting->section_required_flg) <span style="color: red;">*</span> @endif</label>
                    <select id="section" name="section" class="form-control" @if($eventsetting->section_required_flg) required @endif>
                        @foreach ($eventsections as $section)
                            <option value="{{ $section->id }}" {{ old('section') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <h2>ログイン情報設定</h2>

            <div class="form-group">
                <label for="mail">メールアドレス <span style="color: red;">*</span></label>
                <input type="email" id="mail" name="mail" class="form-control" placeholder="メールアドレスを入力してください" value="{{ old('mail') }}" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード <span style="color: red;">*</span></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="パスワードを入力してください" required>
            </div>

            @if ($event->approval == 1)
                <input type="hidden" name="approval" value="0">
            @else
                <input type="hidden" name="approval" value="1">
            @endif

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="terms_agree" style="font-weight: bold;">
                    <input type="checkbox" id="terms_agree" name="terms_agree" required style="margin-right: 5px; width:auto; padding: 0px; border: none; border-radius: 0px;">
                    利用規約に同意します <span style="color: red;">*</span> <a href="#" onclick="openPopup(); return false;">[規約を確認]</a>
                    <script>
                        function openPopup() {
                            const popup = document.createElement('div');
                            popup.style.position = 'fixed';
                            popup.style.left = '50%';
                            popup.style.top = '50%';
                            popup.style.transform = 'translate(-50%, -50%)';
                            popup.style.backgroundColor = 'white';
                            popup.style.border = '1px solid #ccc';
                            popup.style.padding = '20px';
                            popup.style.zIndex = '1000';
                            popup.innerHTML = '{!! $eventbasic->terms !!}<button onclick="closePopup()">閉じる</button>';
                            document.body.appendChild(popup);
                        }

                        function closePopup() {
                            const popup = document.querySelector('div[style*="position: fixed"]');
                            if (popup) {
                                document.body.removeChild(popup);
                            }
                        }
                    </script>
                </label>
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="privacy_agree" style="font-weight: bold;">
                    <input type="checkbox" id="privacy_agree" name="privacy_agree" required style="margin-right: 5px; width:auto; padding: 0px; border: none; border-radius: 0px;">
                    個人情報の取り扱いについて同意します <span style="color: red;">*</span>
                    <a href="#" onclick="openPrivacyPopup(); return false;">[個人情報の取り扱いを確認]</a>
                </label>
            </div>
            <script>
                function openPrivacyPopup() {
                    const popup = document.createElement('div');
                    popup.style.position = 'fixed';
                    popup.style.left = '50%';
                    popup.style.top = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.backgroundColor = 'white';
                    popup.style.border = '1px solid #ccc';
                    popup.style.padding = '20px';
                    popup.style.zIndex = '1000';
                    popup.innerHTML = '{!! $eventbasic->privacy !!}<button onclick="closePopup()">閉じる</button>';
                    document.body.appendChild(popup);
                }

                function closePopup() {
                    const popup = document.querySelector('div[style*="position: fixed"]');
                    if (popup) {
                        document.body.removeChild(popup);
                    }
                }
            </script>

            <button type="submit" class="btn">申込</button>
        </form>
            
        @else
            <div class="alert alert-danger">
                <p>現在、申込期間外です。申込期間は{{ $eventbasic->start }}から{{ $eventbasic->end }}までです。</p>
            </div>
        @endif
    </div>
</body>
</html>
