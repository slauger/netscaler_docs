html:
	asciidoctor -n -a toc=left -a icons *.adoc && \
	ln -f -s README.html index.html

pdf:
	asciidoctor-pdf -n -a toc -a icons *.adoc
