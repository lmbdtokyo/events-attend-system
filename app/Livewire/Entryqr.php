<?php

namespace App\Livewire;

use Livewire\Component;

class Entryqr extends Component
{

    public $qrUrl;

    protected $listeners = ['handleQrUrl'];

    public function handleQrUrl($url)
    {
        // ここでURLを処理し、レスポンスを返す
        $this->qrUrl = $url;

        // 例として、URLをそのまま返す
        $message = 'URL received: ' . $url;

        // URLにアクセスして返ってくるjsonを取得
        $response = file_get_contents($url);
        $json = json_decode($response, true);

        // jsonをメッセージとして設定
        $message = 'URL received: ' . $url . ' - JSON: ' . json_encode($json);

        $this->emit('qrUrlProcessed', $message);
    }

    public function render()
    {
        return view('livewire.entryqr');
    }
}
