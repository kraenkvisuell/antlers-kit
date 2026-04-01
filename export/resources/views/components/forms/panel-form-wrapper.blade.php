<form enctype="multipart/form-data">
    <div x-data="{
        isSaved: $wire.entangle('isSaved'),
        isSent: $wire.entangle('isSent'),
        errors: {{ $this->getErrorBag() }},
        watchEvents() {
            this.$watch('isSaved', value => {
                setTimeout(() => this.isSaved = false, 2000)
            })
    
            if (this.errors && typeof(this.errors) === 'object') {
                setTimeout(() => {
                    let firstError = Object.keys(this.errors)[0]
                    let element = this.$refs[firstError]
    
                    if (element) {
                        let params = { behavior: 'smooth' }
                        element.scrollIntoView(params)
                    }
                }, 100)
            }
    
            this.$watch('isSent', value => {
                if (value) {
                    let element = this.$refs.successMessage
    
                    if (element) {
                        setTimeout(() => {
                            element.scrollIntoView({ behavior: 'smooth' })
                        }, 100)
                    }
                }
            })
        },
        init() {
            this.watchEvents()
        },
    }">
        {{ $slot }}
    </div>

</form>
