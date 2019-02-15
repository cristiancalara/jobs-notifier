/*global toastr */

/**
 * Create a new Axios client instance
 * @see https://github.com/mzabriskie/axios#creating-an-instance
 */
const getClient = () => {
	const client = axios.create();

	// Add a request interceptor
	client.interceptors.request.use(
		requestConfig => requestConfig,
		(requestError) => {
			return Promise.reject(requestError);
		},
	);

	// Add a response interceptor
	client.interceptors.response.use(
		response => response,
		(error) => {
			return Promise.reject(error);
		},
	);

	return client;
};

class API {
	/**
	 *
	 */
	constructor() {
		this.client = getClient();
	}

	/**
	 *
	 * @param route
	 * @param params
	 * @returns {*}
	 */
	get(route, params) {
		return this.request('get', route, params);
	}

	/**
	 *
	 * @param route
	 * @param data
	 * @param config
	 * @returns {Promise}
	 */
	post(route, data, config = {}) {
		return this.request('post', route, data, config);
	}

	/**
	 *
	 * @param route
	 * @param data
	 * @returns {*}
	 */
	put(route, data) {
		return this.request('put', route, data);
	}

	/**
	 *
	 * @param route
	 * @param data
	 * @returns {*}
	 */
	patch(route, data) {
		return this.request('patch', route, data);
	}

	/**
	 *
	 * @param route
	 * @param data
	 * @returns {*}
	 */
	delete(route, data) {
		return this.request('delete', route, data);
	}

	/**
	 *
	 * @param type
	 * @param route
	 * @param data
	 * @param config
	 * @returns {Promise}
	 */
	request(type, route, data, config = {}) {
		switch (type) {
			case 'get':
				return this.client.get(route, Object.assign({
					params: data
				}, config));
			default:
				return this.client(Object.assign({
					method: type,
					url: route,
					data: data
				}, config));
		}
	}

	/**
	 *
	 * @param err
	 */
	handleErrors(err) {
		console.log(err);
		if (!err.response) {
			toastr.error('Whoops, server error has occurred. Please try again later');
			return;
		}

		toastr.error(err.response.data.message);
	}
}

const myAPI = new API();

export default myAPI;