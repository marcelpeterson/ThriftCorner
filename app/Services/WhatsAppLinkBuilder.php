<?php

namespace App\Services;

use App\Models\Item;
use App\Models\User;

class WhatsAppLinkBuilder
{
    /**
     * Generate a WhatsApp link with a templated message.
     */
    public function generateLink(Item $item, ?User $buyer = null, array $customFields = []): string
    {
        // Hide seller phone for unauthenticated users by redirecting to login
        if ($buyer === null) {
            return route('login');
        }

        // Redirect unverified users to profile page
        if (!$buyer->hasVerifiedEmail()) {
            return route('profile') . '?verification_required=true';
        }

        $seller = $item->user;
        $sellerPhone = $this->normalizePhone($seller->phone);

        if (empty($sellerPhone)) {
            return '#';
        }

        $message = $this->buildMessage($item, $seller, $buyer, $customFields);
        $encodedMessage = urlencode($message);

        return "https://wa.me/{$sellerPhone}?text={$encodedMessage}";
    }

    /**
     * Build the message template with placeholders replaced.
     */
    protected function buildMessage(Item $item, User $seller, ?User $buyer, array $customFields): string
    {
        $buyerName = $buyer ? "{$buyer->first_name} {$buyer->last_name}" : '[Your Name]';
        $listingUrl = route('items.view', $item->slug);

        $template = "Hai {seller_name}, aku tertarik dengan listingmu:\n\n"
            . "Item: {listing_title}\n"
            . "Price: {price}\n"
            . "Link: {listing_url}\n\n"
            . "Aku ingin mendiskusikan detailnya. Apakah kita bisa bertemu?\n\n";
            // . "{buyer_name}";

        $replacements = [
            '{seller_name}' => $seller->first_name,
            '{listing_title}' => $item->name,
            '{price}' => $item->price_rupiah,
            '{buyer_name}' => $buyerName,
            '{listing_url}' => $listingUrl,
            '{meet_time}' => $customFields['meet_time'] ?? '[meeting time]',
            '{meet_location}' => $customFields['meet_location'] ?? '[meeting location]',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    /**
     * Normalize phone number for WhatsApp (remove non-digits, handle country code).
     */
    protected function normalizePhone(string $phone): string
    {
        // Remove all non-digit characters
        $phone = preg_replace('/\D/', '', $phone);

        // If starts with 0, replace with 62 (Indonesia)
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with country code, prepend 62
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
