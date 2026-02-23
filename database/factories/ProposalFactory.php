<?php

namespace Database\Factories;

use App\Models\Proposal;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProposalFactory extends Factory
{
    protected $model = Proposal::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'judul_proposal' => 'Proposal '.$this->faker->words(3, true),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'catatan_revisi' => $this->faker->optional(0.3)->sentence(),
            'tanggal_pengajuan' => now()->subDays(rand(1, 30)),
            'file_dokumen' => 'sample_proposal.pdf',
        ];
    }
}
