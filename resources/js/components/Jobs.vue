<template>
	<div>
		<div v-show="loading" class="text-center m-5">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<div v-show="!loading" class="jobs-list">
			<div class="d-flex align-items-center justify-content-end mb-3">
				<span class="pr-2">Sort by:</span>
				<div class="dropdown float-right">
					<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
						{{ sortBy.label }}
					</button>
					<div class="dropdown-menu">
						<a v-for="option in sortByOptions"
						   class="dropdown-item"
						   href="#"
						   @click.prevent="changeSortBy(option)">
							{{ option.label }}
						</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div v-for="job in sortedJobs" :key="job.id" class="job card card-default">
				<div class="card-header d-flex align-items-center">
					<h6 class="w-75 m-0">
						<a :href="job.url" class="text-dark" target="_blank">
							<strong>{{ job.title }}</strong>
						</a>
					</h6>
					<div class="w-25">
						<div class="dropdown float-right">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
								{{ job.status ? job.status.label : 'Select status' }}
							</button>
							<div class="dropdown-menu">
								<a v-for="status in statuses"
								   class="dropdown-item"
								   href="#"
								   @click.prevent="changeStatus(job, status)">
									{{ status.label }}
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<p class="card-subheader">
						<span class="text-muted"><strong>{{ `${job.rating}%` }}</strong></span>
						&ndash;
						<span class="text-muted">{{ fromNow(job) }}</span>
					</p>
					<div v-html="job.snippet" class="snippet"></div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import moment from 'moment';
	import App from '../core/app';
	import API from '../core/api';

	export default {
		props: {
			status: {
				type: Object,
				default: null,
				required: false
			}
		},
		data() {
			let sortByOptions = {
				rating: {
					label: 'Rating',
					func: (a, b) => b.rating - a.rating
				},
				date_created: {
					label: 'Date',
					func: (a, b) => moment.utc(b.date_created).diff(moment.utc(a.date_created))
				}
			};

			return {
				statuses: App.statuses(),
				sortByOptions: sortByOptions,
				sortBy: sortByOptions.rating,
				jobs: [],
				loading: true
			}
		},
		computed: {
			sortedJobs() {
				return this.jobs.sort(this.sortBy.func);
			}
		},
		mounted() {
			this.fetchJobs();
		},
		methods: {
			async fetchJobs() {
				try {
					let {data} = await API.get(route('api.v1.job.index', {
						status: this.status ? this.status.id : null
					}));

					this.jobs = data;
				} catch (e) {
					API.handleErrors(e);
				} finally {
					this.loading = false;
				}
			},

			async changeStatus(job, status) {
				try {
					// Remove immediately.
					this.jobs = this.jobs.filter(j => j.id !== job.id);

					await API.put(route('api.v1.job.update', {job: job.id}), {
						status_id: status.id
					});
				} catch (e) {
					API.handleErrors(e);

					// Add back if there was an issue.
					this.jobs.push(job);
				}
			},

			changeSortBy(sortBy) {
				this.sortBy = sortBy;
			},

			fromNow(job) {
				return moment.utc(job.date_created).fromNow()
			}
		}
	}
</script>
