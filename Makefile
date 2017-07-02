all:
	asciidoctor -n -a toc=left -a icons *.adoc && \
	ln -f -s README.html index.html
