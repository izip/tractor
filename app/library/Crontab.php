<?

 
class Crontab {
	
	/**
	 * Location of the crontab executable
	 * @var string
	 */
	var $crontab = '/usr/bin/crontab';
	
	/**
	 * Location to save the crontab file.
	 * @var string
	 */
	var $destination = '/tmp/CronManager';
	
	/**
	 * Minute (0 - 59)
	 * @var string
	 */
	var $minute	= 0;
	
	/**
	 * Hour (0 - 23)
	 * @var string
	 */
	var $hour = 10;
	
	/**
	 * Day of Month (1 - 31)
	 * @var string
	 */
	var	$dayOfMonth = '*';
	
	/**
	 * Month (1 - 12) OR jan,feb,mar,apr...
	 * @var string
	 */
	var $month = '*';
	
	/**
	 * Day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
	 * @var string
	 */
	var $dayOfWeek = '*';
	
	/**
	 * @var array
	 */
	var $jobs = array();
	
	function Crontab() {
	}
	

	function onMinute($minute) {
		$this->minute = $minute;
		return $this;
	}
	

	function onHour($hour) {
		$this->hour = $hour;
		return $this;
	}
	

	function onDayOfMonth($dayOfMonth) {
		$this->dayOfMonth = $dayOfMonth;
		return $this;
	}
	

	function onMonth($month) {
		$this->month = $month;
		return $this;
	}
	

	function onDayOfWeek($dayOfWeek) {
		$this->dayOfWeek = $dayOfWeek;
		return $this;
	}
	

	function on($timeCode) {
		list(
			$this->minute, 
			$this->hour, 
			$this->dayOfMonth, 
			$this->month, 
			$this->dayOfWeek
		) = explode(' ', $timeCode);
		
		return $this;
	}
	

	function doJob($job) {
		$this->jobs[] =	$this->minute.' '.
						$this->hour.' '.
						$this->dayOfMonth.' '.
						$this->month.' '.
						$this->dayOfWeek.' '.
						$job;
		
		return $this;
	}
	

	function activate($includeOldJobs = true) {
		$contents  = implode("\n", $this->jobs);
		$contents .= "\n";
		
		if($includeOldJobs) {
			$contents .= $this->listJobs();
		}
		
		if(is_writable($this->destination) || !file_exists($this->destination)){
			exec($this->crontab.' -r;');
			file_put_contents($this->destination, $contents, LOCK_EX);
			exec($this->crontab.' '.$this->destination.';');
			return true;
		}
		
		return false;
	}
	

	function listJobs() {
		return exec($this->crontab.' -l;');
	}
}

?>
