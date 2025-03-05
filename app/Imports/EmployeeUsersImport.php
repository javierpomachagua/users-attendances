<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeUsersImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row['dni'])) {
            return null;
        }

        if ($user = User::where('name', $row['name'])->first()) {
            return $user;
        }

        return new User([
            'name' => $row['name'],
            'email' => Str::of($row['name'])->lower()->slug().'@anglo.com',
            'password' => bcrypt('password'),
            'dni' => $row['dni'],
            'is_employee' => true,
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
