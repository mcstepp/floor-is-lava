<script>
	export default {
		props: ['attributes'],

		data() {
			return {
				editing: false,
				body: this.attributes.body,
				originalValue: this.attributes.body
			};
		},

		methods: {
			edit() {
				this.editing = true;
				this.originalValue = this.body;
			},

			update() {
				axios.patch(`/replies/${this.attributes.id}`, {
					body: this.body
				});

				this.editing = false;

				flash('Updated!');
			},

			cancel() {
				this.editing = false;
				this.body = this.originalValue;
			},

			destroy() {
				axios.delete('/replies/' + this.attributes.id);

				$(this.$el).fadeOut(300, () => {
					flash('Reply deleted.');
				});
			}
		}
	}
</script>