import isEqual from 'lodash/isEqual';
import debounce from 'lodash/debounce';

const { __ } = wp.i18n;

const {
	addQueryArgs
} = wp.url;

const apiFetch = wp.apiFetch;

const {
	Component,
	RawHTML
} = wp.element;

const {
	Placeholder,
	Spinner
} = wp.components;

export default class TemplateRender extends Component {
	constructor(props) {
		super(props);

		this.state = {
			response: null,
		};

		this.$createElemen = () => { };
	}

	componentDidMount() {
		this.isStillMounted = true;
		this.fetch();
		// Only debounce once the initial fetch occurs to ensure that the first
		// renders show data as soon as possible.
		this.fetch = debounce(this.fetch, 500);
	}

	componentWillUnmount() {
		this.isStillMounted = false;
	}

	componentDidUpdate(prevProps) {
		const attributes = this.removeExceptions(this.props.attributes),
			prevAttributes = this.removeExceptions(prevProps.attributes);

		if (!isEqual(prevAttributes, attributes)) {
			this.fetch(this.props);
		}
	}

	removeExceptions(obj) {
		const outputObj = Object.assign({}, obj);

		this.props.exceptions.forEach(exception => {
			if (!outputObj.hasOwnProperty(exception))
				return;

			delete outputObj[exception];
		});

		return outputObj;
	}

	fetch() {
		if (!this.isStillMounted)
			return;

		if (null !== this.state.response)
			this.setState({ response: null });

		const path = this.rendererPath();
		const {
			onError = () => { }
		} = this.props;

		// Store the latest fetch request so that when we process it, we can
		// check if it is the current request, to avoid race conditions on slow networks.
		const fetchRequest = (this.currentFetchRequest = apiFetch({ path })
			.then((response) => {
				if (
					this.isStillMounted &&
					fetchRequest === this.currentFetchRequest &&
					response
				) {
					this.setState({ response: response.rendered });
				}
			})
			.catch((error) => {
				if (
					this.isStillMounted &&
					fetchRequest === this.currentFetchRequest
				) {
					this.setState({
						response: {
							error: true,
							errorMsg: error.message,
						},
					});
					onError();
				}
			}));

		return fetchRequest;
	}

	rendererPath() {
		const {
			block,
			attributes = null,
		} = this.props;

		return addQueryArgs(`/wp/v2/block-renderer/${block}`, {
			context: 'edit',
			...(null !== attributes ? { attributes } : {}),
		});
	}

	render() {
		const response = this.state.response;

		const {
			onSuccess = () => { }
		} = this.props;

		if (response === '') {
			// empty response placeholder
			return (
				<Placeholder>
					{__('Block rendered as empty.')}
				</Placeholder>
			);
		} else if (!response) {
			// loading response placeholder
			return (
				<Placeholder>
					<Spinner />
				</Placeholder>
			);
		} else if (response.error) {
			// error response placeholder
			const errorMessage = sprintf(
				// translators: %s: error message describing the problem
				__('Error loading block: %s'),
				response.errorMsg
			);

			return (
				<Placeholder>{errorMessage}</Placeholder>
			);
		}

		setTimeout(onSuccess, 30);

		return (
			<RawHTML key="html">
				{response}
			</RawHTML>
		);
	}
}