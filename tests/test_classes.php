<?php
/**
 * File containing test code for the EventLog component.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package EventLog
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

class testDelayedInitLog implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( '/' ), true) );
    }
}

/**
 * A writer that cannot write: every message raises ezcLogWriterException,
 * as a writer does whose storage fails (a database, a full disk).
 */
class testFailingLogWriter implements ezcLogWriter
{
    public $attempts = 0;

    public function writeLogMessage( $message, $severity, $source, $category, $optional = array() )
    {
        ++$this->attempts;
        throw new ezcLogWriterException( new Exception( "Cannot write '{$message}'." ) );
    }
}
?>
