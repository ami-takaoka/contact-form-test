@extends('layouts.app')

@section('header-button')
<!-- ログアウトボタン -->
<form method="POST" action="/logout">
    @csrf
    <button class="header__link">logout</button>
</form>
@endsection

@section('css')
<!-- 管理画面専用のCSS -->
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="admin__content">

        <!-- 管理画面のヘッダー -->
        <div class="admin__heading">
            <h2>Admin</h2>
        </div>

        <!-- 検索フォーム -->
        <form class="form" method="GET" action="/search">
            <div class="form__group form__group--keyword">
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">
                    </div>
                </div>
            </div>

            <!-- 性別フィルター -->
            <div class="form__group form__group--gender">
                <div class="form__group-content">
                    <div class="form__input--select">
                        <select name="gender">
                            <option value="">性別</option>
                            @foreach ($genders as $value => $label)
                                <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>
                                {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- カテゴリーフィルター -->
            <div class="form__group form__group--category">
                <div class="form__group-content">
                    <div class="form__input--select">
                        <select name="category">
                            <option value="">お問い合わせの種類</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->content }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- 日付フィルター -->
            <div class="form__group form__group--date">
                <div class="form__group-content">
                    <div class="form__input--date">
                        <input type="date" name="date" value="{{ request('date') }}">
                    </div>
                </div>
            </div>

            <!-- 検索とリセットボタン -->
            <div class="form__button">
                <button class="form__button-submit" type="submit">検索</button>

                <a href="/reset" class="form__button-reset">
                    リセット
                </a>
            </div>

        </form>

        <!-- エクスポートボタンとページネーション -->
        <div class="admin__header">
            <div class="admin__export">
                <!-- エクスポートフォーム -->
                <form method="GET" action="/export">
                    <button class="admin__export-btn">エクスポート</button>
                </form>
            </div>

            <!-- ページネーション -->
            <div class="admin__pagination">
                {{ $contacts->links('pagination::default') }}
            </div>
        </div>

        <!-- ユーザー情報表示テーブル -->
        <div class="admin__table">
            <table class="admin__table-inner">
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                    <tr>
                        <!-- ユーザーの基本情報表示 -->
                        <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                        <td>
                            <!-- 性別表示 -->
                            @if ($contact->gender == 1)
                                男性
                            @elseif ($contact->gender == 2)
                                女性
                            @elseif ($contact->gender == 3)
                                その他
                            @endif
                        </td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ optional($contact->category)->content }}</td>
                        <td>
                            <!-- 詳細ボタン -->
                            <button class="admin__detail-btn"
                            data-id="{{ $contact->id }}"
                            data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
                            data-gender="{{ $contact->gender }}"
                            data-email="{{ $contact->email }}"
                            data-tel="{{ $contact->tel }}"
                            data-address="{{ $contact->address }}"
                            data-building="{{ $contact->building }}"
                            data-category="{{ optional($contact->category)->content }}"
                            data-detail="{{ $contact->detail }}"
                            >
                            詳細</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- モーダルウィンドウ -->
        <div class="modal" id="detail-modal">
            <div class="modal__inner">
                <div class="modal__content">
                    <!-- モーダルの閉じるボタン -->
                    <button class="modal__close" id="modal-close">×</button>

                    <table class="modal__table">
                        <!-- モーダルに表示するユーザー情報 -->
                        <tr>
                            <th>お名前</th>
                            <td id="modal-name"></td>
                        </tr>
                        <tr>
                            <th>性別</th>
                            <td id="modal-gender"></td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td id="modal-email"></td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td id="modal-tel"></td>
                        </tr>
                        <tr>
                            <th>住所</th>
                            <td id="modal-address"></td>
                        </tr>
                        <tr>
                            <th>建物名</th>
                            <td id="modal-building"></td>
                        </tr>
                        <tr>
                            <th>お問い合わせの種類</th>
                            <td id="modal-category"></td>
                        </tr>
                        <tr>
                            <th>お問い合わせ内容</th>
                            <td id="modal-detail"></td>
                        </tr>
                    </table>

                    <!-- 削除ボタン -->
                    <div class="modal__button">
                        <form method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="modal__delete">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 詳細ボタンとモーダルのスクリプト -->
    <script>
        document.querySelectorAll('.admin__detail-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // モーダル内の情報をボタンのデータ属性から設定
                document.getElementById('modal-name').textContent = this.dataset.name;

                const gender = this.dataset.gender == 1 ? '男性'
                            : this.dataset.gender == 2 ? '女性'
                            : this.dataset.gender == 3 ? 'その他'
                            : '';

                // 各フィールドにデータをセット
                document.getElementById('modal-gender').textContent = gender;
                document.getElementById('modal-email').textContent = this.dataset.email;
                document.getElementById('modal-tel').textContent = this.dataset.tel;
                document.getElementById('modal-address').textContent = this.dataset.address;
                document.getElementById('modal-building').textContent = this.dataset.building;
                document.getElementById('modal-category').textContent = this.dataset.category;
                document.getElementById('modal-detail').textContent = this.dataset.detail;

                // 削除フォームのアクションを設定
                document.getElementById('delete-form').action = "/delete/" + this.dataset.id;

                // モーダルを表示
                document.getElementById('detail-modal').style.display = 'block';
            });
        });

        // モーダルを閉じる
        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('detail-modal').style.display = 'none';
        });
    </script>

@endsection