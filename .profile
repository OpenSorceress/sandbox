alias ls='ls -alG'
alias vi='vim -n'
alias updatedb='sudo /usr/libexec/locate.updatedb'
alias grep='grep --color=auto'

if [[ $EUID -ne 0 ]]; then
        export PS1="\[\033[0;33m\]\u \[\033[0;36m\]@ \[\033[0;35m\]\h \[\033[0;34m\]\W \[\033[0;32m\]\d \n\[\033[0;32m\]\$\[\033[0m\] " ;
else
        export PS1="\[\033[0;31m\]\u \[\033[0;36m\]@ \[\033[0;35m\]\h \[\033[0;34m\]\W \[\033[0;32m\]\d \n\[\033[0;32m\]\$\[\033[0m\] " ;
fi

export PATH=/usr/local/php5/bin:$PATH
export INFOPATH='/usr/local/share/info:/usr/share/info'
