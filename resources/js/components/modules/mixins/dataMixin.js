import axios from "axios";

export default {
  data() {

    const paginationDefaults = this.getPaginationDefaults();

    return {
        errors: [],
        items: [],
        filter: {},
        loading: false,
        pageTotal: '',
        sort: {
            field: '',
            direction: '',
        },
        pagination: paginationDefaults.pagination,
        paginated: paginationDefaults.paginated,

    };
  },

  methods: {
    async loadData(apiUrl, resetPagination = false) {
        try {

            if (resetPagination) {
                this.goToFirstPage();
            }

            this.loading = true;

            const response = await axios.get(apiUrl, {
                params: {
                    ...this.getFilterParams(),
                    page: this.paginated.page,
                    perPage: this.paginated.perPage,
                    sort_field: this.sort.field,
                    sort_direction: this.sort.direction
                },
            });

            this.updateItems(response.data.data);
            this.pageTotal = response.data.totalAmount;
            this.loading = false;

        } catch (error) {
            this.loading = false;
            this.errors = error.response.data.errors;

            console.log(this.errors)

            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors;
                for (let field in errors) {
                    this.showToast(errors[field][0], { type: "error" });
                }
            } else {
                console.error(error);
            }
        };
    },

    updateItems(data) {
      this.items = data.data;
      this.pagination = data.links;

      const totalPages = Math.ceil(data.total / this.paginated.perPage);
      this.paginated.totalPages = totalPages;
      this.paginated.currentPage = data.current_page;
      this.paginated.lastPage = data.last_page;
    },

    getFilterParams() {
      throw new Error(
        "getFilterParams() must be implemented in the component"
      );
    },

    getPaginationDefaults() {
      return {
        pagination: [],
        paginated: {
          page: 1,
          perPage: 10,
          totalPages: 0,
          currentPage: 1,
          lastPage: 1,
        },
      };
    },

    goToFirstPage() {
        if (this.paginated.currentPage !== 1) {
            this.paginated.page = 1;
            this.fetchData();
        }
    },

    goToLastPage() {
        if (this.paginated.currentPage !== this.paginated.lastPage) {
            this.paginated.page = this.paginated.lastPage;
            this.fetchData();
        }
    },

    goToPage(pageUrl) {
        if (pageUrl) {
            const queryParams = new URLSearchParams(pageUrl.split('?')[1]);
            const newPage = queryParams.get('page');
            if (newPage) {
                this.paginated.page = parseInt(newPage, 10);
                this.fetchData();
            }
        }
    },

    toggleSort(field) {
        if (this.sort.field === field) {
            this.sort.direction = this.sort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            this.sort.field = field;
            this.sort.direction = 'asc';
        }
        this.fetchData();
    },

    getSortIconClass(field) {
        if (this.sort.field !== field) {
            return 'mdi-sort';
        }
        return this.sort.direction === 'asc' ? 'mdi-sort-ascending' : 'mdi-sort-descending';
    },

  },
};
