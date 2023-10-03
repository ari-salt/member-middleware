<?php

namespace AriSALT\MemberMiddleware;

use Illuminate\Support\Facades\DB;

class MySQLMemberRepository implements MemberRepository
{
	public function getMemberIDByForgerockID(
		string $forgerockID,
		string $table,
		string $fieldMemberID,
		string $fieldForgerockID
	): string {
		$result = DB::table($table)
			->select($fieldMemberID)
			->where([
				$fieldForgerockID => $forgerockID,
				'o_published' => 1
			])
			->limit(1)
			->first($fieldMemberID);

		return $result->oo_id;
	}
}