<template>
    <div class="position-absolute top-0 end-0 bottom-0 start-0 bg-light d-flex justify-content-center align-items-center">
        <div>
            <h2 class="text-center mb-4">{{ data.status + ': ' + data.statusText }}</h2>
            <div>{{ data.data.message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data']
}
</script>