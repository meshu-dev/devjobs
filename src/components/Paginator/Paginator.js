import React, { Component } from 'react';
import Pagination from 'react-bootstrap/Pagination';

class Paginator extends Component {

	getPageLinks(total, active = 1) {
    let items = [];

    for (let number = 1; number <= total; number++) {
      items.push(
        <Pagination.Item key={number} href={ `${this.props.url}/${number}` } active={number == active}>
          {number}
        </Pagination.Item>,
      );
    }
    return items;
  }

  render() {
    let active = this.props.active ? parseInt(this.props.active) : 1;
    let pages = this.getPageLinks(this.props.total, active);

    if (pages.length > 0) {
      if (active > 1) pages.unshift(<Pagination.Prev href={ `${this.props.url}/${active - 1}` } />);
      if (active < this.props.total) pages.push(<Pagination.Next href={ `${this.props.url}/${active + 1}` } />);
    }

    return (
      <Pagination>{ pages }</Pagination>
    );
  }
}

export default Paginator;
