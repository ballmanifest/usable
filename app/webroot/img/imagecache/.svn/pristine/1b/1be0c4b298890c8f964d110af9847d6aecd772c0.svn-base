<?php
	App::uses('AppHelper', 'View/Helper');

	class MiniCalendarsHelper extends AppHelper {
	
		public $helpers = array('Html');
		public $calendar = '';

		// draw calendar
		
		private function _pad($x = null) {
			$x = $x < 10 ? '0' . $x : $x;
			return $x;
		}
		private function _mk_sql_date($y = null, $m = null, $d = null) {
			$sql_date = $y . '-' . $this->_pad($m) . '-' . $this->_pad($d);
			return $sql_date;
		}
		
		public function drawCalendar() {
		
			// calendar config
			
			$cMonth = date('n');
			$cYear = date('Y');
			$today = date('Y-m-d');
			$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
			$maxday = date('t', $timestamp);
			$running_day = date('w', $timestamp);
			$pMonth = ($cMonth - 1) == 0 ? 12 : ($cMonth-1);
			$pYear = ($pMonth == 12) ? ($cYear - 1) : $cYear;
			$nMonth = ($cMonth + 1) == 13 ? 1 : ($cMonth + 1);
			$nYear = $nMonth == 1 ? ($cYear + 1) : $cYear;
			$prev_month_maxday = date('t', mktime(0, 0, 0, $pMonth, 1, $pYear));
			$flag = false;
			
			// constructing calendar
			
			$this->calendar .= 
						'<table id="calender_itself">
							<thead>
								<tr>
									<td>SUN</td>
									<td>MON</td>
									<td>TUE</td>
									<td>WED</td>
									<td>THR</td>
									<td>FRI</td>
									<td>SAT</td>
								</tr>
							</thead>
							<tbody>';
			for( $i = 0; $i < 42; $i++ ){	
				$date_cell_cls = 'date_cell';
				$curdate = $i - $running_day + 1;
				$year = $cYear;
				$month = $cMonth;
				if( $i % 7 == 0 ) {
					$this->calendar .= '<tr>';
				}
				if ($i >= $running_day &&  $i <= $maxday) {
					$day =  $curdate;
				} else if( $i > $maxday ) {
					if( $day < $maxday ) {
						$day++;
					} else {
						$flag = true;
						$day = ($day - $maxday == 0) ? ($day - $maxday + 1) : ($day - $maxday);
					}
				} else if( $i < $running_day ) {
					$day = $prev_month_maxday + $curdate; 
					$year = $pYear;
					$month = $pMonth;
					$date_cell_cls .= ' date_past';
				}
				if($flag) {
					$year = $nYear;
					$month = $nMonth;
					$date_cell_cls .= ' date_future';
				}
				$mydate = $this->_mk_sql_date($year, $month, $day);
				if($mydate == $today) {
					$date_cell_cls .= ' date_selected';
				}		
				$this->calendar .=  '<td class="' . $date_cell_cls . '" data-mydate="' . $mydate . '"><span>' . $day . '</span><br></td>';
				if($i % 7 == 6) {
					$this->calendar .= '</tr>';
				}
			}
			$this->calendar .= 
						'</tbody>
					</table>';
			return $this->calendar;
		}
	}		
?>
