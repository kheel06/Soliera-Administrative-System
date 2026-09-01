$c = App\Models\LegalContract::where('title', 'like', '%Service Level Agreement%')->first();
$c->file_path = 'contracts/mock_sla.pdf';
$c->save();
echo "DONE: " . $c->file_path;
exit;