<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('category');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = str_replace(' ', '', $request->keyword);
            $keyword = str_replace('　', '', $keyword);

            $query->where(function ($q) use ($keyword) {
                $q->whereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // カテゴリ検索
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 日付検索
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7)->appends($request->query());

        $categories = Category::all();

        $genders = [
            1 => '男性',
            2 => '女性',
            3 => 'その他'
        ];

        return view('admin.index', compact('contacts', 'categories', 'genders'));
    }

    // 検索リセット機能
    public function reset()
    {
        return redirect('/admin');
    }

    // 削除機能
    public function delete(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    // 既存削除（ID付き）
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect('/admin');
    }

    // エクスポート機能（CSV）
    public function export(Request $request)
    {
        $contacts = Contact::with('category')->get();

        $csvHeader = [
            'お名前',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせの種類',
            'お問い合わせ内容'
        ];

        $callback = function () use ($contacts, $csvHeader) {
            $stream = fopen('php://output', 'w');

            // 文字化け対策
            fprintf($stream, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($stream, $csvHeader);

            foreach ($contacts as $contact) {
                $gender = $contact->gender == 1 ? '男性'
                        : ($contact->gender == 2 ? '女性' : 'その他');

                fputcsv($stream, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $gender,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    optional($contact->category)->content,
                    $contact->detail,
                ]);
            }

            fclose($stream);
        };

        return response()->streamDownload($callback, 'contacts.csv');
    }
}