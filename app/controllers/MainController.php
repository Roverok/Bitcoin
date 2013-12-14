<?php

class MainController extends BaseController {
	public function getAccountInfo() {
		$result = $this->request('getAccountInfo', []);
		$result = json_decode($result);
		return View::make('account_info')->with('account_info',$result);
	}

	public function getMarketDepth2() {
		$result = $this->request('getMarketDepth2',[5]);
		$result = json_decode($result);
		return View::make('market_info')->with('market_info', $result)->with('bid_value',reset($result->result->market_depth->bid)->price)->with('ask_value',reset($result->result->market_depth->ask)->price);
	}

	public function getOrders() {
		$result = $this->request('getOrders',[false]);
		$result = json_decode($result);
		return View::make('order_info')->with('order_info',$result);
	}

	public function getTransactions() {
		$result = $this->request('getTransactions',[]);
		$result = json_decode($result);
		return View::make('transactions_info')->with('transactions_info',$result);
	}

	public function getDeposits() {
		$result = $this->request('getDeposits',["BTC"]);
		$result = json_decode($result);
		return View::make('deposits_info')->with('deposits_info',$result);		
	}

	public function buyOrder() {
		if (floatval($_POST['price'])==0) {
			$price = NULL;
		} else {
			$price = floatval($_POST['price']);
		}
		$result = $this->request('buyOrder',[$price,floatval($_POST['amount'])]);
		$result = json_decode($result);
		if (isset($result->result)) {
			if ($result->result=="true") {
				return Response::make("Success");
			} else {
				return Response::make("Unknown");
			}
		} else {
			if (isset($result->error)) {
				return  Response::make($result->error->code.$result->error->message);
			} else {
				return Response::make("Unknown");
			}
		}
	}

	public function sellOrder() {
		if (floatval($_POST['price'])<4000.0) {
			$price = NULL;
		} else {
			$price = floatval($_POST['price']);
		}
		$result = $this->request('sellOrder',[$price,floatval($_POST['amount'])]);
		$result = json_decode($result);
		if (isset($result->result)) {
			if ($result->result=="true") {
				return Response::make("Success");
			} else {
				return Response::make("Unknown");
			}
		} else {
			if (isset($result->error)) {
				return  Response::make($result->error->code." ".$result->error->message);
			} else {
				return Response::make("Unknown");
			}
		}
	}

	public function cancelOrder() {
		$result = $this->request('cancelOrder',[intval($_POST['id'])]);
		$result = json_decode($result);
		if (isset($result->result)) {
			if ($result->result=="true") {
				return Response::make("Success");
			} else {
				return Response::make("Unknown");
			}
		} else {
			if (isset($result->error)) {
				if(($result->error->code==-32026)||($result->error->code==-32025)) {
					return Response::make("Success");
				} else {
					return  Response::make($result->error->code." ".$result->error->message);
				}
			} else {
				return Response::make("Unknown");
			}
		}
	}

	public function getOrderStatus() {
		$result = $this->request('getOrders',[]);
		$result = json_decode($result);
		if (!count($result->result->order)) {
			return Response::make("closed");
		} else {
			return Response::make($result->result->order[0]->id);
		}
	}

	private function sign($method, $params){
		$accessKey = Auth::user()->accessKey; 
		$secretKey = Auth::user()->secretKey;
		
		$mt = explode(' ', microtime());
		$ts = $mt[1] . substr($mt[0], 2, 6);
		
		$signature = urldecode(http_build_query(array(
			'tonce' => $ts,
			'accesskey' => $accessKey,
			'requestmethod' => 'post',
			'id' => 1,
			'method' => $method,
	        'params' => implode(',', $params),
	    )));
		
		$hash = hash_hmac('sha1', $signature, $secretKey);
		
		return array(
			'ts' => $ts,
			'hash' => $hash,
			'auth' => base64_encode($accessKey.':'. $hash),
		);
	}

	private function request($method, $params){
		$sign = $this->sign($method, $params);

		$options = array( 
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ' . $sign['auth'],
				'Json-Rpc-Tonce: ' . $sign['ts'],
				),
			);

		$postData = json_encode(array(
			'method' => $method,
			'params' => $params,
			'id' => 1,
		));
		$this->writeLog('Send Request', $postData);
		$headers = array(
			'Authorization: Basic ' . $sign['auth'],
			'Json-Rpc-Tonce: ' . $sign['ts'],
			);        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 
			'Mozilla/4.0 (compatible; BTC China Trade Bot; '.php_uname('a').'; PHP/'.phpversion().')'
			);

		curl_setopt($ch, CURLOPT_URL, 'https://api.btcchina.com/api_trade_v1.php');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    	// run the query
		$res = curl_exec($ch);
		return $res;
	}

	private function writeLog($method, $Log) {
		$fp = fopen(public_path().'/Log.txt','a');
		// create table header for csv file 
		fputs($fp, date('Y-m-d H:i:s')."  ".$method.":  ".$Log."\n");
		fclose($fp);
	}

	private function getLog() {
		return Response::download(public_path().'/errorlog.csv');
	}
}

