<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssistantUsersImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }

        if ($user = User::where('dni', $row['dni'])->first()) {
            $user->update([
                'invitations' => $row['invitations'],
            ]);

            return $user;
        }

        return new User([
            'name' => $row['name'],
            'email' => Str::of($row['name'])->lower()->slug().'@anglo.com',
            'password' => bcrypt('password'),
            'dni' => $row['dni'],
            'invitations' => $row['invitations'],
        ]);
    }
}
