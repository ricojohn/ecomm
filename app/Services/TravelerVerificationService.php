<?php

namespace App\Services;

use Carbon\Carbon;

class TravelerVerificationService
{
    /**
     * Verify traveler eligibility for duty-free purchasing.
     *
     * Returns ['eligible' => bool, 'status' => string, 'message' => string]
     */
    public function verify(array $data): array
    {
        // Departure date guard (double-check beyond form validation)
        $departureDate = Carbon::parse($data['departure_date']);

        if ($departureDate->isPast() && ! $departureDate->isToday()) {
            return [
                'eligible' => false,
                'status'   => 'rejected',
                'message'  => 'Departure date is in the past. Duty-free purchase not permitted.',
            ];
        }

        // Flight number format guard
        if (! preg_match('/^[A-Z]{2}\d{3,4}$/', $data['flight_number'])) {
            return [
                'eligible' => false,
                'status'   => 'rejected',
                'message'  => 'Flight number format is invalid.',
            ];
        }

        // Simulate external eligibility check — always passes if rules are met
        return [
            'eligible' => true,
            'status'   => 'verified',
            'message'  => 'Traveler verified. You are eligible for duty-free purchase.',
        ];
    }
}
