<?php

namespace App\Console\Commands;

use App\Mail\GenericEmail;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailDailyForPlayerBirthDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'player:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email day for admin the items of player birthday';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('m-d');
        $today = Carbon::today()->format('m-d');
        $playersWithBirthdayToday = Player::whereRaw('DATE_FORMAT(birth_date, "%m-%d") = ?', [$today])
            ->with(['clubs' => function ($query) {
                $query->limit(1);
            }])
            ->get();

        $csvFileName = 'players_birthday_' . Carbon::today()->format('Y_m_d') . '.csv';
        $csvFilePath = storage_path('app/public/' . $csvFileName);
        $fileHandle = fopen($csvFilePath, 'w');
        fprintf($fileHandle, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($fileHandle, ['ID', 'Nom du joueur', 'Date d\'anniversaire', 'Club']);
        foreach ($playersWithBirthdayToday as $player) {
            // Convert the player data to UTF-8 encoding
            $playerId = mb_convert_encoding($player->id, 'UTF-8');
            $playerFullName = mb_convert_encoding($player->full_name, 'UTF-8');
            $playerBirthDate = mb_convert_encoding($player->birth_date, 'UTF-8');
            $playerClub = mb_convert_encoding(count($player->clubs) > 0 ? $player->clubs[0]?->full_name : 'sans club', 'UTF-8');
            fputcsv($fileHandle, [
                $playerId,
                $playerFullName,
                $playerBirthDate,
                $playerClub
            ]);
        }

        fclose($fileHandle);

        // Send email
        $emailDetails = [
            'subject' => 'Players Birthday List for ' . Carbon::today()->format('Y-m-d'),
            'view' => 'mail.players_birthday',
            'data' => ['date' => Carbon::today()->format('Y-m-d')],
            'attachment' => $csvFilePath,
            'attachmentName' => $csvFileName
        ];

        Mail::to('admin@example.com')->send(new GenericEmail($emailDetails));
    }
}
