<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームの初期画面を表示
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // お問い合わせフォームの表示
        return view('contact.index');
    }

    /**
     * お問い合わせ確認画面を表示
     * 
     * @param  \App\Http\Requests\ContactRequest  $request
     * @return \Illuminate\View\View
     */
    public function confirm(ContactRequest $request)
    {
        // フォームから送信されたデータを取得
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 
            'tel1', 'tel2', 'tel3', 'address', 'building', 
            'category', 'content'
        ]);
        
        // 確認画面へデータを渡して表示
        return view('contact.confirm', compact('contact'));
    }

    /**
     * お問い合わせ内容をデータベースに保存
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ユーザーが「戻る」ボタンを押した場合、入力内容を保持してフォームに戻す
        if ($request->input('action') === 'back') {
            return redirect('/')
                ->withInput(); // 入力内容を保持
        }
        
        // フォームから送信されたデータを取得
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 
            'tel1', 'tel2', 'tel3', 'address', 'building', 
            'category', 'content'
        ]);

        // 電話番号を結合
        $tel = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        // DBに保存するためのデータ準備
        $saveData = [
            'category_id' => $contact['category'],
            'last_name'   => $contact['last_name'],
            'first_name'  => $contact['first_name'],
            'gender'      => $contact['gender'],
            'email'       => $contact['email'],
            'tel'         => $tel,
            'address'     => $contact['address'],
            'building'    => $contact['building'],
            'detail'      => $contact['content'],
        ];

        // データベースに保存
        Contact::create($saveData);

        // サンクスページにリダイレクト
        return redirect('/thanks');
    }

    /**
     * サンクスページを表示
     * 
     * @return \Illuminate\View\View
     */
    public function thanks()
    {
        // サンクスページを表示
        return view('contact.thanks');
    }
}