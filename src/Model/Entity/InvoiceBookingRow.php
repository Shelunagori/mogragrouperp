<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceBookingRow Entity
 *
 * @property int $id
 * @property int $invoice_booking_id
 * @property int $item_id
 * @property int $quantity
 * @property float $rate
 * @property float $amount
 * @property string $description
 *
 * @property \App\Model\Entity\InvoiceBooking $invoice_booking
 * @property \App\Model\Entity\Item $item
 */
class InvoiceBookingRow extends Entity
{

}
