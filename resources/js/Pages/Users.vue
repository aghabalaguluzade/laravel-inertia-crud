<template>
    <Head title="Users" />
    <h1 class="text-4xl font-bold">Users</h1>

    <div style="margin-top: 400px">
        <p>Time current time is {{time}}.</p>
    </div>

    <Link href="/users" class="text-blue-500" preserve-scroll>Refresh</Link>

</template>

<script setup>
    defineProps({time : String})
</script>
