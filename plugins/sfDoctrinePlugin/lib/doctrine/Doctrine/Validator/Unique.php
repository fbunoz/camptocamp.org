<?php
/*
 *  $Id: Unique.php 1567 2007-06-04 18:47:26Z runa $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.com>.
 */

/**
 * Doctrine_Validator_Unique
 *
 * @package     Doctrine
 * @category    Object Relational Mapping
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.com
 * @since       1.0
 * @version     $Revision: 1567 $
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 */
class Doctrine_Validator_Unique
{
    /**
     * @param Doctrine_Record $record
     * @param string $key
     * @param mixed $value
     * @param string $args
     * @return boolean
     */
    public function validate(Doctrine_Record $record, $key, $value, $args)
    {
        $table = $record->getTable();
        $pks = $table->getIdentifier();
        if ( is_array($pks) ) {
            $pks = join(',',$pks);
        }

        $sql   = 'SELECT ' . $pks . ' FROM ' . $table->getTableName() . ' WHERE ' . $key . ' = ?';
        
        $values = array();
        $values[] = $value;
        
        // If the record is not new we need to add primary key checks because its ok if the 
        // unique value already exists in the database IF the record in the database is the same
        // as the one that is validated here.
        $state = $record->getState();
        if (! ($state == Doctrine_Record::STATE_TDIRTY || $state == Doctrine_Record::STATE_TCLEAN)) {
            foreach ($table->getPrimaryKeys() as $pk) {
                $sql .= " AND {$pk} != ?";
                $values[] = $record->$pk;
            }
        }
        
        $stmt  = $table->getConnection()->getDbh()->prepare($sql);
        $stmt->execute($values);

        return ( ! is_array($stmt->fetch()));
    }
}
