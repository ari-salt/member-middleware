<?php

namespace AriSALT\MemberMiddleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closure;
use Exception;
use AriSALT\Logger\Logger;

class MemberMiddleware
{
	public function handle(
		Request $request,
		Closure $next,
		string $from,
		string $table,
		string $fieldMemberID,
		string $fieldForgerockID,
		string $varName,
		string $logTitle,
		string $logFilename
	) {
		if (empty($request->get($from))) {
			return response()->json([
				'status' => false,
				'code' => 'AUTH401',
				'message' => null,
				'errorMessage' => [
					'token' => [__('message.required')]
				],
				'data' => null
			], Response::HTTP_UNAUTHORIZED);
		}

		$memberID = '';

		try {
			$memberRepository = new MySQLMemberRepository();
			$memberID = $memberRepository->getMemberIDByForgerockID(
				$request->get($from),
				$table,
				$fieldMemberID,
				$fieldForgerockID
			);
		} catch (Exception $e) {
			Logger::logging($logTitle, $logFilename, $e->getMessage());
			return response()->json([
				'status' => false,
				'code' => 'AUTH500',
				'message' => null,
				'errorMessage' => [
					'token' => [$e->getMessage()]
				],
				'data' => null
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}

		$request->request->add([
			$varName => $memberID
		]);

		return $next($request);
	}
}