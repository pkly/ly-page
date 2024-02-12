<template>
    <div class="header-block mb-3 pb-3 px-3 border-bottom border-info-subtle">
        <header>
            <slot name="header"/>
        </header>
        <div>
            <slot name="default"/>
        </div>
    </div>
</template>

<style scoped lang="scss">
header {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}
</style>