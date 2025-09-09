<?php

namespace App\Http\Controllers;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailTestController extends Controller
{
    public function sendTest()
    {
        $data = ['name' => 'Nguyễn Văn A'];

        Mail::to('khuongvanhiep04@gmail.com')->send(new TestMail($data));

        return "Đã gửi mail thành công!";
    }
}
