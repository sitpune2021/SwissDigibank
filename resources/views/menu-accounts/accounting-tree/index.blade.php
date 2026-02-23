@extends('layout.main')

@section('content')
    <style>
        /* TREE CONNECTOR LINES */
        .tree ul {
            position: relative;
            padding-left: 28px;
        }

        .tree ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10px;
            border-left: 1px dashed #b1b3b6;
            height: 100%;
        }

        .tree li {
            position: relative;
            list-style: none;
            padding: 6px 0 6px 22px;
        }

        .tree li::before {
            content: '';
            position: absolute;
            top: 16px;
            left: 5px;

            width: 14px;
            border-top: 1px solid #cbd5e1;
        }

        .tree>ul>li::before {
            border-top: none;
        }

        .tree-icon {
            width: 20px;
            text-align: center;
            display: inline-block;
            color: #64748b;
        }

        .jstree-icon.jstree-ocl {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 6px;
            position: relative;
        }

        /* arrow style */
        .jstree-icon.jstree-ocl::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            border-style: solid;
            border-width: 5px 0 5px 6px;
            border-color: transparent transparent transparent #64748b;
        }

        /* optional hover effect */
        .tree li:hover>div .jstree-ocl::before {
            border-left-color: #111827;
        }

        .jstree-open::before {
            transform: rotate(90deg);
        }

        .jstree-closed::before {
            transform: rotate(0deg);
        }

        .jstree-ocl {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 6px;
            cursor: pointer;
            position: relative;
            vertical-align: middle;
        }

        .jstree-ocl::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            border-style: solid;
            border-width: 5px 0 5px 6px;
            border-color: transparent transparent transparent #475569;
            transition: 0.15s;
        }

        .jstree-open::before {
            transform: rotate(90deg);
        }

        /* hide children initially */
        .jstree-parent>ul {
            display: none;
        }

        .jstree-parent.open>ul {
            display: block;
        }
    </style>
    <div class="container">

        <div class="flex flex-wrap items-center justify-between gap-4 px-4 lg:mb-4">
        <h3 class=" flex text-lg  uppercase font-semibold">
           ACCOUNTING TREE
        </h3>

    </div>
      

        {{-- Branch Filter --}}
        <div class="flex justify-center mt-4  box">
            <form class="mb-4">
            <select name="branch_id" class="form-control  w-64 border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                <option value="">ALL BRANCH</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary rounded-10 text-sm">GET</button>
        </form>
        </div>

        <div class="card shadow-sm box mt-5">
            <div class="card-body tree">

                <ul style="list-style-type:none; padding-left:0;">

                    <li>
                        <div class="flex items-center font-semibold tracking-wide">
                            <i class="jstree-icon jstree-ocl"></i>
                            <span class="tree-icon">⚙</span>
                            <span class="ml-1">ACCOUNTING</span>
                        </div>

                        <ul style="list-style-type:none; margin-left:20px;">

                            @foreach($tree as $type => $ledgers)

                                <li class="mt-3">
                                    <i class="fa fa-folder text-warning"></i>
                                    <i class="jstree-icon jstree-ocl" role="presentation"></i>
                                    
                                    <strong>{{ $type }}</strong>

                                    <ul style="list-style-type:none; margin-left:20px;">

                                        @foreach($ledgers as $ledger)

                                            <li class="d-flex justify-content-between border-bottom py-1">

                                                <span>
                                                   
                                                    <span class="tree-icon">
                                                        ⚡
                                                    </span>
                                                    {{ $ledger['name'] }}
                                                    ( {{ $ledger['system'] }} )
                                                </span>

                                                <span>
                                                    {{ number_format($ledger['amount'], 2) }}
                                                </span>

                                            </li>

                                        @endforeach

                                    </ul>
                                </li>

                            @endforeach

                        </ul>

                    </li>

                </ul>

            </div>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            document.querySelectorAll(".jstree-ocl").forEach(icon => {

                let li = icon.closest("li");

                if (li.querySelector("ul")) {
                    li.classList.add("jstree-parent", "open");   // ← open by default
                    icon.classList.add("jstree-open");          // ← arrow rotated
                } else {
                    icon.style.visibility = "hidden";
                }

                icon.addEventListener("click", function (e) {
                    e.stopPropagation();

                    li.classList.toggle("open");
                    icon.classList.toggle("jstree-open");
                    icon.classList.toggle("jstree-closed");
                });

            });

        });
    </script>
@endsection