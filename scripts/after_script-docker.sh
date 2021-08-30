docker images -a --filter='dangling=false' --format '{{.Repository}}:{{.Tag}} {{.Size}}'
