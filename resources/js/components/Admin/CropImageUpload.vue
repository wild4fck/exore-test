<!--suppress HtmlRequiredAltAttribute -->
<template>
    <div class="row m-0 w-100">
        <div class="col-sm-8 px-1 mb-sm-3 mb-3">
            <img ref="image" :src="src" class="w-100">
        </div>
        <div class="col-sm-4">
            <input :name="fieldName" :value="destination" type="hidden">
            <img ref="destinationImage" :src="destination" :style="{width: size.width/4, height: size.height/4}"
                 class="img-fluid preview-image">
            <div class="mt-2 w-100 text-center" style="font-family: 'Nunito', sans-serif">
                Preview
            </div>
        </div>
    </div>
</template>

<script>

import Cropper from 'cropperjs';

export default {
    name: 'CropImageUpload',
    props: {
        size: Object,
        srcProp: '',
    },
    watch: {
        srcProp: function (newVal, oldVal) {
            this.cropper.reset().clear().replace(newVal);
        }
    },
    data() {
        return {
            cropper: {},
            destination: {},
            images: {},
            src: this.srcProp
        }
    },
    computed: {
        fieldName() {
            return 'photos[' + this.size.width + 'x' + this.size.height + ']'
        }
    },
    methods: {
        init() {
            this.image = this.$refs.image;
            this.cropper = new Cropper(this.image, {
                zoomable: true,
                autoCropArea: 1,
                scalable: true,
                aspectRatio: this.size.width / this.size.height,
                viewMode: 3,
                background: false,
                crop: () => {
                    const canvas = this.cropper.getCroppedCanvas({
                        width: this.size.width,
                        height: this.size.height,
                    });
                    this.destination = canvas.toDataURL("image/png");
                },

            });
        }
    },
    mounted() {
        this.init();
    },
}
</script>

<style lang="sass">
@import '~cropperjs/dist/cropper.css'
</style>

<style scoped>
.preview-image {
    border: solid 1px #000;
}
</style>

