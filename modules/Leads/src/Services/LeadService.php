<?php

namespace Modules\Leads\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Leads\Models\LeadModel;
use Modules\Leads\Models\LeadAttachmentModel;

class LeadService
{
    /**
     * Create a new lead
     */
    public function create(array $data): LeadModel
    {
        $lead = LeadModel::create([
            'name'          => $data['name'],
            'email'         => $data['email'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'company'       => $data['company'] ?? null,
            'status_id'     => fn_get_setting('general.lead.status'),
            'source_id'     => $data['source_id'] ?? null,
            'value'         => $data['value'] ?? 0,
            'description'   => $data['description'] ?? null,
            'industries'    => !empty($data['industry']) ?? json_encode($data['industry']) ?? '',
            'website'       => $data['website'] ?? '',
            'address'       => $data['address'] ?? '',
            'address_2'     => $data['address_2'] ?? '',
            'country'       => $data['country'] ?? '',
            'state'         => $data['state'] ?? '',
            'city'          => $data['city'] ?? '',
            'postal_code'   => $data['postal_code'] ?? '',
            'custom_fields' => $data['custom_fields'] ?? '',
            'created_by'    => auth('admin')->id(),
        ]);

        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
            $lead->syncTags($tags);
        }

        return $lead;
    }

    /**
     * Update an existing lead
     */
    public function update(LeadModel $lead, array $data): LeadModel
    {
        $lead->update($data);

        if (!empty($data['tags'])) {
            $tags = array_unique(array_map('trim', explode(',', $data['tags'])));
            $lead->syncTags($tags);
        }

        return $lead;
    }

    /**
     * Handle file uploads for leads
     */
    public function handleAttachments(Request $request, LeadModel $lead): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $size = $file->getSize();
                $path = 'uploads/leads/' . $lead->id;

                Storage::disk(fn_get_setting('general.image_driver'))->putFileAs($path, $file, $fileName);

                LeadAttachmentModel::create([
                    'lead_id'            => $lead->id,
                    'admin_id'           => auth('admin')->id(),
                    'filename'           => $fileName,
                    'original_filename'  => $originalName,
                    'mime_type'          => $mimeType,
                    'size'               => $size,
                ]);
            }
        }
    }

    /**
     * Update lead assignment
     */
    public function assignLead(LeadModel $lead, int $adminId, string $adminName): LeadModel
    {
        $lead->update(['assigned_to' => $adminId]);

        $lead->notes()->create([
            'admin_id' => auth('admin')->id(),
            'note'     => auth('admin')->name . " Assigned Lead to " . $adminName,
            'created'  => now(),
        ]);

        return $lead;
    }
}
