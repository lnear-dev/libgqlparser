/* @flow */
/* @generated */
/* jshint ignore:start */

/**
 * Copyright 2023-present, Lnear
  * All rights reserved.
 */

type Node = {
  kind: string;
  start?: ?number;
  end?: ?number;
};

type OperationKind = 'query' | 'mutation' | 'subscription';
type Node =  Stmt
  | Expr


type Program = Node & {
  kind: 'Program';
  statements: Array<Stmt[]>;
}

type Stmt = Node & {
  kind: 'Stmt';
