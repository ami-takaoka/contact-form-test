@extends('layouts.app')

@section('css')
  <!-- 確認画面専用CSS -->
  <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@section('content')
    <div class="confirm__content">

      <!-- ページタイトル -->
      <div class="confirm__heading">
            <h2>Confirm</h2>
      </div>

      <!-- 送信フォーム（最終送信 or 修正） -->
      <form class="form" action="/thanks" method="post">
        @csrf

        <!-- =============================
             確認テーブル
        ============================== -->
        <div class="confirm-table">
          <table class="confirm-table__inner">

            <tr class="confirm-table__row">
              <th class="confirm-table__header">お名前</th>
              <td class="confirm-table__text">

                <!-- 表示用（readonly） -->
                <input type="text" value="{{ $contact['last_name'] }}　{{ $contact['first_name'] }}" readonly>

                <!-- 送信用hidden -->
                <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">性別</th>
              <td class="confirm-table__text">

                <!-- 性別表示用変換 -->
                @php
                  $genderText = ['1' => '男性', '2' => '女性', '3' => 'その他'];
                @endphp

                <!-- 表示用 -->
                <input type="text" value="{{ $genderText[$contact['gender']] }}" readonly>

                <!-- 送信用 -->
                <input type="hidden" name="gender" value="{{ $contact['gender'] }}">

              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">メールアドレス</th>
              <td class="confirm-table__text">
                <input type="text" value="{{ $contact['email'] }}" readonly>
                <input type="hidden" name="email" value="{{ $contact['email'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">電話番号</th>
              <td class="confirm-table__text">

                <!-- 表示用 -->
                <input type="text" value="{{ $contact['tel1'] }}{{ $contact['tel2'] }}{{ $contact['tel3'] }}" readonly>

                <!-- 送信用 -->
                <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}">
                <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}">
                <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}">
              </td>
            </tr>

            <!-- 住所 -->
            <tr class="confirm-table__row">
              <th class="confirm-table__header">住所</th>
              <td class="confirm-table__text">
                <input type="text" value="{{ $contact['address'] }}" readonly>
                <input type="hidden" name="address" value="{{ $contact['address'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">建物名</th>
              <td class="confirm-table__text">
                <input type="text" value="{{ $contact['building'] }}" readonly>
                <input type="hidden" name="building" value="{{ $contact['building'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせの種類</th>
              <td class="confirm-table__text">

                <!-- カテゴリー表示用変換 -->
                @php
                  $categoryText = [
                    '1' => '商品のお届けについて',
                    '2' => '商品の交換について',
                    '3' => '商品トラブル',
                    '4' => 'ショップへのお問い合わせ',
                    '5' => 'その他'
                  ];
                @endphp

                <!-- 表示用 -->
                <input type="text" value="{{ $categoryText[$contact['category']] }}" readonly>

                <!-- 送信用 -->
                <input type="hidden" name="category" value="{{ $contact['category'] }}">

              </td>
            </tr>

            <!-- お問い合わせ内容 -->
            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせ内容</th>
              <td class="confirm-table__text">
                {!! nl2br(e($contact['content'])) !!}
                <input type="hidden" name="content" value="{{ $contact['content'] }}">
              </td>
            </tr>

          </table>
        </div>

        <!-- =============================
             送信・修正ボタン
        ============================== -->
        <div class="form__button">

            <button class="form__button-submit" type="submit">
                送信
            </button>

            <button type="submit" name="action" value="back" class="form__link">
                修正
            </button>

        </div>

      </form>
    </div>
@endsection