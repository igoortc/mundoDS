<template>
    <div class="row">
    <div class="col-md-12">
        <input v-if="empty" type="file" class="form-control uploader" v-on:change="upload($event.target.files)" accept="image/*" />
        <span v-if="uploading">Uploading your photo... <i class="fa fa-spinner fa-spin"></i></span>
        <span v-if="uploaded">Uploaded successfully! <i class="fa fa-check"></i></span>
    </div>
    </div>
 </template>

<script>
    export default {
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
                thumbs: []
            }
        },
        computed: {
            clUrl: function() {
                return 'https://api.cloudinary.com/v1_1/' + this.cloudinary.cloudName + '/upload'
            },
        },
        methods: {
            upload: function(file) {
                const formData = new FormData()
                formData.append('file', file[0])
                formData.append('upload_preset', this.cloudinary.uploadPreset)
                this.empty = false
                this.uploading = true
                let self = this
                axios.post(this.clUrl, formData).then(res => {
                    this.thumbs.unshift({
                        url: res.data.secure_url
                    })
                    self.uploading = false
                    self.uploaded = true
                    $('#photo').val(res.data.secure_url)
                    $('#poster').val(res.data.secure_url)
                    $('#image').val(res.data.secure_url)
                    $('#photoProfile').val(res.data.secure_url)
                })
            }
        }
    }
</script>