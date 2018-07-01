<template>
    <div class="row">
        <div class="col-xs-8 col-md-10">
            <input v-if="empty" type="file" class="form-control uploader" v-on:change="upload($event.target.files)" accept="image/*" />
            <span v-if="uploading">Uploading your photo... <i class="fa fa-spinner fa-spin"></i></span>
            <span v-if="uploaded">Uploaded successfully! <i class="fa fa-check"></i></span>
        </div>
        <div class="col-xs-4 col-md-2 thumb" style="padding-right: 0">
            <img v-if="thumb && !newThumb" :src="thumb" />
            <img v-if="newThumb" :src="'http://res.cloudinary.com/ht0shxjqw/image/upload/c_fill,h_50,w_50/'+newThumb" />
        </div>
    </div>
 </template>

<script>
    export default {
        props: ['thumb'],
        data: function() {
            return {
                cloudinary: {
                    uploadPreset: 'b9f0htxa',
                    apiKey: '286881872822949',
                    cloudName: 'ht0shxjqw'
                },
                empty: true,
                uploading: false,
                uploaded: false,
                thumbs: [],
                newThumb: ''
            }
        },
        computed: {
            clUrl: function() {
                return `https://api.cloudinary.com/v1_1/${this.cloudinary.cloudName}/upload`
            },
        },
        methods: {
            upload: function(file) {
                const formData = new FormData()
                formData.append('file', file[0])
                formData.append('upload_preset', this.cloudinary.uploadPreset)
                this.empty = false
                this.uploading = true
                this.$http.post(this.clUrl, formData).then(res => {
                    this.thumbs.unshift({
                        url: res.data.secure_url
                    })
                    this.uploading = false
                    this.uploaded = true
                    this.newThumb = res.data.public_id
                    $('#photo').val(res.data.secure_url)
                    $('#poster').val(res.data.secure_url)
                    $('#image').val(res.data.secure_url)
                    $('#photoProfile').val(res.data.secure_url)
                })
            }
        }
    }
</script>