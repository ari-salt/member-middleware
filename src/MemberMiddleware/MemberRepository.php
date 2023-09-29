<?php

namespace AriSALT\MemberMiddleware;

interface MemberRepository
{
	public function getMemberIDByForgerockID(
		string $forgerockID,
		string $table,
		string $fieldMemberID,
		string $fieldForgerockID
	): string;
}