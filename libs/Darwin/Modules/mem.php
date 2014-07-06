<?php

namespace Modules;

class mem extends \ld\Modules\Module
{
    protected $name = 'mem';

    public function getData($args = array())
    {
        $FREE_BLOCKS = exec(
            "vm_stat | grep free | awk '{ print $3 }' | sed 's/\.//'"
        );
        $INACTIVE_BLOCKS = exec(
            "vm_stat | grep inactive | awk '{ print $3 }' | sed 's/\.//'"

        );
        $SPECULATIVE_BLOCKS = exec(
            "vm_stat | grep speculative | awk '{ print $3 }' | sed 's/\.//'"
        );
        $ACTIVE_BLOCKS = exec(
            "vm_stat | grep active | awk '{ print $3 }' | sed 's/\.//'"

        );
        $PURGE_BLOCKS = exec(
            "vm_stat | grep purgeable | awk '{ print $3 }' | sed 's/\.//'"

        );
        $WIRED_BLOCKS = exec(
            "vm_stat | grep wired | awk '{ print $4 }' | sed 's/\.//'"
        );
        $TOTAL_MEMORY = exec(
            "/usr/sbin/sysctl -a | grep 'hw.memsize:' | awk -F ':' '{ print $2 }'"
        );
        $freeMem = ((int)$FREE_BLOCKS + (int)$SPECULATIVE_BLOCKS * 4096) / 1048576;
        $activeMem = ($ACTIVE_BLOCKS * 4096) / 1048576;
        $inActiveMem = ($INACTIVE_BLOCKS * 4096) / 1048576;
        $wiredMem = ($WIRED_BLOCKS * 4096) / 1048576;
        $purgeMem = ($PURGE_BLOCKS * 4096) / 1048576;


        $totalMem = $TOTAL_MEMORY / 1048576;
        $result = array('', round($totalMem), round($wiredMem + $activeMem + $inActiveMem), round($freeMem));

        return $result;
    }
}
