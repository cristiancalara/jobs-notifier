/*global Ziggy, JobsNotifier, route*/

export default class App {
	static onReady() {
		new App();
	}

	constructor() {
		this.$ = {};
	}

	/**
	 * Returns logged in user
	 * @returns {Object}
	 */
	static user() {
		return JobsNotifier.user;
	}

	/**
	 * Returns logged in user id
	 * @returns {Integer|null}
	 */
	static userId() {
		let user = App.user();
		return user ? user.id : null;
	}

	/**
	 * Jobs statuses.
	 * @returns {[]}
	 */
	static statuses() {
		return JobsNotifier.statuses || [];
	}

	/**
	 * Returns absolute path to an asset
	 * @param path
	 * @returns {string}
	 */
	static asset(path) {
		return `${Ziggy.baseUrl}${path}`;
	}

	/**
	 *
	 * @param name
	 * @param parameters
	 * @param version
	 */
	static apiRoute(name, parameters = {}, version = 'v1') {
		name = `api.${version}.${name}`;
		return route(name, parameters);
	}

	/**
	 * Returns absolute url
	 * @param path
	 * @returns {string}
	 */
	static url(path) {
		return `${Ziggy.baseUrl}${path}/`;
	}
}