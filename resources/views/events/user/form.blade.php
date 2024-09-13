<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント申込フォーム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
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
    </style>
</head>
<body>
    <div class="container">

        @if ($eventbasic->image)
                <img src="{{ asset('storage/' . $eventbasic->image) }}" alt="イベント画像" style="max-width: 100%; height: auto;">
        @endif

        <h1>{{ $eventbasic->title }}</h1>

        <h2>{{ $eventbasic->overview_title }}</h2>

        <p>
            {{ $eventbasic->overview_text }} 
        </p>


        <h2>お申込みフォーム</h2>
            
        <form action="{{ route('eventform.store', $event->id) }}" method="POST">
            @csrf
            @method('PATCH')

            @if ($eventsetting->company_flg)
                <div class="form-group">
                    <label for="company">{{ $eventsetting->company_display_name }} @if($eventsetting->company_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="company" name="company" class="form-control" placeholder="{{ $eventsetting->company_placeholder }}" @if($eventsetting->company_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->division_flg)
                <div class="form-group">
                    <label for="division">{{ $eventsetting->division_display_name }} @if($eventsetting->division_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="division" name="division" class="form-control" placeholder="{{ $eventsetting->division_placeholder }}" @if($eventsetting->division_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->post_flg)
                <div class="form-group">
                    <label for="post">{{ $eventsetting->post_display_name }} @if($eventsetting->post_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="post" name="post" class="form-control" placeholder="{{ $eventsetting->post_placeholder }}" @if($eventsetting->post_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->postal_code_flg)
                <div class="form-group">
                    <label for="postal_code">{{ $eventsetting->postal_code_display_name }} @if($eventsetting->postal_code_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="{{ $eventsetting->postal_code_placeholder }}" @if($eventsetting->postal_code_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->address1_flg)
                <div class="form-group">
                    <label for="address1">{{ $eventsetting->address1_display_name }} @if($eventsetting->address1_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="address1" name="address1" class="form-control" placeholder="{{ $eventsetting->address1_placeholder }}" @if($eventsetting->address1_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->address2_flg)
                <div class="form-group">
                    <label for="address2">{{ $eventsetting->address2_display_name }} @if($eventsetting->address2_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="address2" name="address2" class="form-control" placeholder="{{ $eventsetting->address2_placeholder }}" @if($eventsetting->address2_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->address3_flg)
                <div class="form-group">
                    <label for="address3">{{ $eventsetting->address3_display_name }} @if($eventsetting->address3_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="address3" name="address3" class="form-control" placeholder="{{ $eventsetting->address3_placeholder }}" @if($eventsetting->address3_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->tel_flg)
                <div class="form-group">
                    <label for="tel">{{ $eventsetting->tel_display_name }} @if($eventsetting->tel_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="text" id="tel" name="tel" class="form-control" placeholder="{{ $eventsetting->tel_placeholder }}" @if($eventsetting->tel_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->birth_flg)
                <div class="form-group">
                    <label for="birth">{{ $eventsetting->birth_display_name }} @if($eventsetting->birth_required_flg) <span style="color: red;">*</span> @endif</label>
                    <input type="date" id="birth" name="birth" class="form-control" placeholder="{{ $eventsetting->birth_placeholder }}" @if($eventsetting->birth_required_flg) required @endif>
                </div>
            @endif

            @if ($eventsetting->section_flg)
                <div class="form-group">
                    <label for="section">{{ $eventsetting->section_display_name }} @if($eventsetting->section_required_flg) <span style="color: red;">*</span> @endif</label>
                    <select id="section" name="section" class="form-control" @if($eventsetting->section_required_flg) required @endif>
                        @foreach ($eventsections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <h2>ログイン情報設定</h2>

            <div class="form-group">
                <label for="login_id">ログインID <span style="color: red;">*</span></label>
                <input type="text" id="login_id" name="login_id" class="form-control" placeholder="ログインIDを入力してください" required>
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


            <button type="submit" class="btn">申込</button>
        </form>
    </div>
</body>
</html>
