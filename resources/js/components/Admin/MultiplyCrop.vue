<template>
    <div>
        <input class="form-control mb-3" readonly style="height: 43px" type="file" @change="selectFile">

        <div v-if="src.length > 0">
            <div v-for="(size, index) in sizes" class="mb-5">
                <h3>Размер: {{ size.width }}x{{ size.height }}</h3>
                <crop-image-upload :key="index" :ref="'cropper'+index" :size="size" :srcProp="src"></crop-image-upload>
            </div>
        </div>
        <div v-else-if="curImages">
            <div v-for="(image, size) in curImages" class="mb-5">
                <h3>The size: {{ size }}</h3>
                <img :src="image" alt="" style="max-width: 100%">
            </div>
        </div>
    </div>
</template>

<script>
import CropImageUpload from "./CropImageUpload";

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

export default {
    name: 'MultiplyCrop',
    components: {CropImageUpload},
    props: {
        sizes: Array,
        curImages: {
            type: Object,
            required: false,
        }
    },
    data() {
        return {
            src: ''
        }
    },
    methods: {
        async selectFile(event) {
            if (event.target.files[0]) {
                this.src = await toBase64(event.target.files[0]);
            }
        }
    },
}
</script>
