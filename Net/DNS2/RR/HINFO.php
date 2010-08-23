<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * DNS Library for handling lookups and updates. 
 *
 * PHP Version 5
 *
 * Copyright (c) 2010, Mike Pultz <mike@mikepultz.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Mike Pultz nor the names of his contributors 
 *     may be used to endorse or promote products derived from this 
 *     software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Networking
 * @package    Net_DNS2
 * @author     Mike Pultz <mike@mikepultz.com>
 * @copyright  2010 Mike Pultz <mike@mikepultz.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id: HINFO.php 63 2010-08-23 05:35:49Z mike $
 * @link       http://pear.php.net/package/Net_DNS2
 * @since      File available since Release 1.0.0
 */

//
// HINFO Resource Record - RFC1035 section 3.3.2
//
//    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
//    /                      CPU                      /
//    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
//    /                       OS                      /
//    +--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+--+
//
class Net_DNS2_RR_HINFO extends Net_DNS2_RR
{
	public $cpu;
	public $os;

	protected function _toString()
	{
		return $this->_formatString($this->cpu) . ' ' . $this->_formatString($this->os);
	}
	protected function _fromString(array $rdata)
	{
		$data = $this->_buildString($rdata);
		if (count($data) == 2) {

			$this->cpu 	= $data[0];
			$this->os	= $data[1];

			return true;
		}

		return false;
	}
	protected function _set(Net_DNS2_Packet &$packet)
	{
		if ($this->rdlength > 0) {
			$offset = $packet->offset;
	
			$this->cpu 	= trim(Net_DNS2_Packet::label($packet, $offset), '"');
			$this->os 	= trim(Net_DNS2_Packet::label($packet, $offset), '"');
		}

		return true;
	}
	protected function _get(Net_DNS2_Packet &$packet)
	{
		if (strlen($this->cpu) > 0) {

			$data  = pack('C', strlen($this->cpu)) . $this->cpu;
			$data .= pack('C', strlen($this->os))  . $this->os;

			return $data;
		}

		return null;
	}
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
