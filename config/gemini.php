<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemini Model Settings
    |--------------------------------------------------------------------------
    |
    | You can swap models without touching code. Default keeps the fast flash
    | variant. Override with GEMINI_MODEL in .env if needed.
    |
    */
    'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),

    /*
    |--------------------------------------------------------------------------
    | Input Guardrails
    |--------------------------------------------------------------------------
    |
    | Hard cap on characters sent to the API to avoid huge payloads and cost.
    |
    */
    'max_chars' => env('GEMINI_MAX_CHARS', 6000),

    /*
    |--------------------------------------------------------------------------
    | Few-shot legal examples
    |--------------------------------------------------------------------------
    |
    | Curated, domain-specific examples to steer the model toward accurate
    | legal classifications and risk signals for your workflows.
    |
    */
    'legal_examples' => [
        [
            'title' => 'Privacy Policy',
            'category' => 'Policy',
            'risk' => 'Medium',
            'text' => "This Privacy Policy explains how Soliera collects, uses, and protects guest information, including CCTV footage, access logs, and visitor IDs. It cites Data Privacy Act (RA 10173), NPC circulars, and data subject rights.",
        ],
        [
            'title' => 'Hotel Event Contract',
            'category' => 'Contract',
            'risk' => 'High',
            'text' => "Event services agreement between Soliera and Client for ballroom rental. Clauses include fees, cancellation penalties, indemnity, liability cap, force majeure, and governing law (PH).",
        ],
        [
            'title' => 'Cease and Desist',
            'category' => 'Legal Notice',
            'risk' => 'High',
            'text' => "Formal cease-and-desist letter demanding halt of trademark infringement of 'Soliera' brand, with 48-hour deadline and threat of injunction and damages.",
        ],
        [
            'title' => 'Financial Statement',
            'category' => 'Financial',
            'risk' => 'Medium',
            'text' => "Quarterly financial statement summarizing revenues, expenses, EBITDA, and variance analysis for Soliera Hospitality properties.",
        ],
        [
            'title' => 'Incident Report',
            'category' => 'Report',
            'risk' => 'Medium',
            'text' => "Security incident report describing guest injury at lobby, CCTV references, witness statements, and remedial actions.",
        ],
        [
            'title' => 'Memorandum to Staff',
            'category' => 'Memorandum',
            'risk' => 'Low',
            'text' => "Internal memo instructing staff on updated visitor badge issuance procedures and front-desk verification checklist.",
        ],
    ],
];
