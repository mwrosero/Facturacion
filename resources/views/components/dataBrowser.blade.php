<?php
use Illuminate\Support\Facades\Request;
?>
<script>
    const serverData = {
        'ip': '{{ Request::ip() }}',
        'user_agent': '{{ Request::header("User-Agent") }}',
        'accept_header': '{{ Request::header("Accept") }}'
    };
</script>