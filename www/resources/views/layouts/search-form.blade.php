
        <!-- search form -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input
                    class="form-control form-control-navbar"
                    name="search"
                    type="search" placeholder="Cerca" aria-label="Cerca"
                    autocomplete="off"
                    v-model="$root.search.query"
                    >
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
