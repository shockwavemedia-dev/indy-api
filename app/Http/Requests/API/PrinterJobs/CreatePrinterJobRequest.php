<?php

declare(strict_types=1);

namespace App\Http\Requests\API\PrinterJobs;

use App\Http\Requests\BaseRequest;

final class CreatePrinterJobRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'string|nullable',
            'product' => 'string|nullable',
            'option' => 'string|nullable',
            'kinds' => 'nullable',
            'quantity' => 'nullable',
            'run_ons' => 'nullable',
            'format' => 'string|nullable',
            'final_trim_size' => 'string|nullable',
            'reference' => 'string|nullable',
            'notes' => 'string|nullable',
            'additional_options' => 'array|nullable',
            'delivery' => 'string|nullable',
            'price' => 'string|nullable',
            'blind_shipping' => 'boolean|nullable',
            'reseller_samples' => 'boolean|nullable',
            'stocks' => 'string|nullable',
            'coding' => 'string|nullable',
            'address' => 'string|nullable',
            'purchase_order_number' => 'string|nullable',
            'attachments' => '',
//            'printer_id' => [
//                'int',
//                'nullable',
//                'exists:App\Models\Printer,id',
//            ],
        ];
    }
}
