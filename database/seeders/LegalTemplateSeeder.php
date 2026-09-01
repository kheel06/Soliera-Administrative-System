<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\LegalTemplate::truncate();
        \App\Models\LegalClause::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Sample Templates
        \App\Models\LegalTemplate::create([
            'name' => 'Non-Disclosure Agreement (NDA)',
            'code' => 'NDA-2026-MUTUAL',
            'category' => 'NDA',
            'description' => 'Standard mutual NDA for vendors and partners. Updated for 2026 compliance.',
            'content' => '<h1 style="text-align: center; font-family: \'Times New Roman\', serif;">NON-DISCLOSURE AGREEMENT</h1>
<p style="text-align: center;"><strong>("Agreement")</strong></p>

<p>This Non-Disclosure Agreement is entered into as of <strong>' . date('F j, Y') . '</strong> ("Effective Date") by and between:</p>

<p>(a) <strong><span contenteditable="false">SOLIERA HOTEL</span></strong>, with principal offices at [HOTEL ADDRESS] ("Disclosing Party"); and</p>

<p>(b) <strong>[COUNTERPARTY_NAME]</strong>, with principal offices at [COUNTERPARTY_ADDRESS] ("Receiving Party").</p>

<p>The parties hereby agree as follows:</p>

<h3>1. DEFINITION OF CONFIDENTIAL INFORMATION</h3>
<p>"Confidential Information" means all non-public information, whether written, oral, or visual, disclosed by Disclosing Party to Receiving Party, including but not limited to guest data, financial records, business plans, and operational strategies.</p>

<h3>2. OBLIGATIONS OF RECEIVING PARTY</h3>
<p>Receiving Party agrees to:</p>
<ul>
    <li>Hold all Confidential Information in strict confidence.</li>
    <li>Use such information solely for the purpose of [DESCRIBE_PURPOSE].</li>
    <li>Not disclose such information to any third party without prior written consent.</li>
</ul>

<h3>3. TERM</h3>
<p>This Agreement shall remain in effect for a period of <strong>[NUMBER]</strong> years from the Effective Date.</p>

<h3>4. GOVERNING LAW</h3>
<p>This Agreement shall be governed by and construed in accordance with the laws of [JURISDICTION].</p>

<p style="margin-top: 2em;"><strong>IN WITNESS WHEREOF</strong>, the parties have executed this Agreement as of the date first above written.</p>

<table style="width: 100%; margin-top: 40px;">
    <tr>
        <td><strong>SOLIERA HOTEL</strong></td>
        <td><strong>[COUNTERPARTY_NAME]</strong></td>
    </tr>
    <tr>
        <td>By: __________________________</td>
        <td>By: __________________________</td>
    </tr>
    <tr>
        <td>Name: [SIGNER_NAME]</td>
        <td>Name: [SIGNER_NAME]</td>
    </tr>
</table>',
            'version' => '3.2',
            'status' => 'approved',
            'tags' => ['mandatory', 'ph-compliant', 'confidentiality']
        ]);

        \App\Models\LegalTemplate::create([
            'name' => 'Employment Contract',
            'code' => 'EMP-2026-FT',
            'category' => 'employment',
            'description' => 'Standard full-time employment agreement with IP assignment clauses.',
            'content' => 'STANDARD EMPLOYMENT CONTRACT CONTENT...',
            'version' => '2.1',
            'status' => 'approved',
            'tags' => ['labor-code', 'full-time']
        ]);

        \App\Models\LegalTemplate::create([
            'name' => 'Service Level Agreement (SLA)',
            'code' => 'SLA-2026-IT',
            'category' => 'service_contract',
            'description' => 'Template for IT and maintenance service providers.',
            'content' => 'STANDARD SLA CONTENT...',
            'version' => '1.0',
            'status' => 'draft',
            'tags' => ['vendor', 'it-services']
        ]);

        // Sample Clauses
        \App\Models\LegalClause::create([
            'title' => 'Confidentiality (Standard)',
            'content' => 'The Receiving Party agrees to hold in strict confidence all Confidential Information...',
            'category' => 'General',
            'is_mandatory' => true
        ]);

        \App\Models\LegalClause::create([
            'title' => 'Force Majeure',
            'content' => 'Neither party shall be liable for any failure or delay in performance due to acts of God, war, pandemic...',
            'category' => 'Risk',
            'is_mandatory' => true
        ]);

        \App\Models\LegalClause::create([
            'title' => 'Dispute Resolution (Arbitration)',
            'content' => 'Any dispute shall be referred to arbitration in accordance with the rules of the Philippine Institute of Arbitrators...',
            'category' => 'Litigation',
            'is_mandatory' => false
        ]);
    }
}
